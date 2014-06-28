<?php

namespace Vetruvet\LaravelSelfUpdater;

use Artisan;
use Config;
use Input;
use Lang;
use Mail;
use View;
use Illuminate\Routing\Controller;
use Symfony\Component\Console\Output\StreamOutput;

class UpdateController extends Controller {
    public function triggerManualUpdate() {
        return $this->doUpdate(false);
    }

    public function triggerAutoUpdate() {
        if (!Input::isJson()) return '';
        if (Input::json('ref') === 'refs/heads/' . Config::get('self-updater::branch', 'master')) {
            return $this->doUpdate(true);
        }
        return '';
    }

    protected function doUpdate($auto) {
        $root = base_path();

        $success     = false;
        $migrate_out = $git_pull_out = $git_log_out = $git_commit_hash = '';

        $error = $error_out = '';

        exec('cd "' . $root . '"; git status --porcelain | grep .;', $status_out, $status_return);

        if ($status_return != 0) {
            exec('cd "' . $root . '"; git pull origin ' . Config::get('self-updater::branch', 'master') . ' 2>&1;', $git_pull_out, $pull_return);
            $git_pull_out = join("\n", $git_pull_out);

            if ($pull_return == 0) {
                exec('cd "' . $root . '"; git log --oneline ORIG_HEAD..;', $git_log_out);
                $git_log_out  = join("\n", $git_log_out);

                $git_commit_hash = substr(trim(`git rev-parse HEAD`), Config::get('self-updater::commit_hash_length', 0));

                Artisan::call('clear-compiled');
                Artisan::call('dump-autoload');
                Artisan::call('optimize');

                $migrate_tmp = fopen('php://memory', 'w+');
                Artisan::call('migrate', array('--force' => true), new StreamOutput($migrate_tmp));
                rewind($migrate_tmp);
                $migrate_out = stream_get_contents($migrate_tmp);

                $success = true;
            } else {
                $error = Lang::get('self-updater::messages.pull_failed', array('pull_exit_code' => $pull_return));
            }
        } else {
            $error     = Lang::get('self-updater::messages.dirty_tree');
            $error_out = join("\n", $status_out);
        }

        $site_name = Config::get('self-updater::site_name');
        if (empty($site_name)) $site_name = Input::server('SERVER_NAME');

        $email_data = array(
            'site_name'    => $site_name,
            'auto'         => $auto,
            'success'      => $success,
            'git_pull_out' => $git_pull_out,
            'git_log_out'  => $git_log_out,
            'migrate_out'  => $migrate_out,
            'error'        => $error,
            'error_out'    => $error_out,
        );

        if (Config::get('self-updater::email')) {
            Mail::send('self-updater::update_email', $email_data, function ($message) use ($site_name, $success, $git_commit_hash) {
                $from = Config::get('self-updater::email.from.address', Config::get('mail.from.address'));
                $from_name = Config::get('self-updater::email.from.name', Config::get('mail.from.name'));

                $subject = Config::get('self-updater::email.subject', null);

                $to = Config::get('self-updater::email.to', $from);
                $reply_to = Config::get('self-updater::email.reply_to', $from);
                
                if (is_array($subject)) {
                    if (isset($subject[$success ? 'success' : 'error'])) {
                        $subject = $subject[$success ? 'success' : 'error'];
                    } else {
                        $subject = null;
                    }
                }

                if (is_callable($subject)) {
                    $subject = $subject($site_name, $success, $git_commit_hash);
                } 

                if (empty($subject)) {
                    if ($success) {
                        $subject = Lang::get('self-updater::messages.subject_success', array('site_name' => $site_name, 'commit_hash' => $git_commit_hash));
                    } else {
                        $subject = Lang::get('self-updater::messages.subject_error', array('site_name' => $site_name));
                    }
                }

                $message->from($from, $from_name)->replyTo($reply_to)->to($to)->subject($subject);
            });
        }

        if (!$auto) {
            return View::make('self-updater::update_email', $email_data);
        }

        return '';
    }
}
