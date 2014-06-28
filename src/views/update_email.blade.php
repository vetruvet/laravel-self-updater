{{ Lang::get('self-updater::messages.email_'.($auto ? 'auto' : 'manual').'_'.($success ? 'success' : 'failure'), array('site_name' => $site_name)) }}

@if (!$success)
    <br /><br />
    {{ Lang::get('self-updater::messages.email_error_label') }}
    {{ empty($error) ? Lang::get('self-updater::messages.email_unknown_error') : $error }}
    @if (!empty($error_out))
        <br />
        <pre>{{ $error_out }}</pre>
    @endif
@endif

<br /><br />
{{ Lang::get('self-updater::messages.email_git_pull') }}<br />
{{ str_repeat('=', strlen(Lang::get('self-updater::messages.email_git_pull'))) }}<br />
<pre>{{ $git_pull_out }}</pre>

@if (!empty($git_log_out))
    <br /><br />
    {{ Lang::get('self-updater::messages.email_commits') }}<br />
    {{ str_repeat('=', strlen(Lang::get('self-updater::messages.email_commits'))) }}<br />
    <pre>{{ $git_log_out }}</pre>
@endif

@if ($success)
    <br /><br />
    {{ Lang::get('self-updater::messages.email_migrate') }}<br />
    {{ str_repeat('=', strlen(Lang::get('self-updater::messages.email_migrate'))) }}<br />
    <pre>{{ $migrate_out }}</pre>
@endif
