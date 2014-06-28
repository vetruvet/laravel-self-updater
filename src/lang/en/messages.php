<?php

return array(
    'pull_failed'     => 'The pull failed (:pull_exit_code) - see git pull output for details.',
    'dirty_tree'      => 'The tree is not clean - modifications have been made directly to files without using git.',
    'subject_success' => ':site_name Self-Updater Success: :commit_hash',
    'subject_error'   => ':site_name Self-Updater ERROR',

    'email_auto_success'   => 'The :site_name Self-Updater was triggered automatically in response to code push (via web hook) and the pull was successful.',
    'email_auto_failure'   => 'The :site_name Self-Updater was triggered automatically in response to code push (via web hook) and the pull FAILED.',
    'email_manual_success' => 'The :site_name Self-Updater was triggered manually and the pull was successful.',
    'email_manual_failure' => 'The :site_name Self-Updater was triggered manually and the pull FAILED.',

    'email_error_label'   => 'ERROR: ',
    'email_unknown_error' => 'Unknown error',

    'email_git_pull' => 'Raw "git pull" output:',
    'email_commits'  => 'Commits pulled:',
    'email_migrate'  => 'Raw "php artisan migrate" output:',
);