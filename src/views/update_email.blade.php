{{--
  Copyright (C) 2014 Valera Trubachev
 
  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at
 
  http://www.apache.org/licenses/LICENSE-2.0
 
  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
--}}

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
