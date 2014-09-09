<?php
/**
 * Copyright (C) 2014 Valera Trubachev
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

return array(
    'error_cancelled'       => 'The update was cancelled by a pre-update event hook.',
    'error_pull_failed'     => 'The pull failed (:pull_exit_code) - see git pull output for details.',
    'error_dirty_tree'      => 'The tree is not clean - modifications have been made directly to files without using git.',
    'error_migration'       => 'An error occurred while running database migration(s).',

    'from_name' => ':site_name Self-Updater',

    'subject_success' => ':site_name Self-Updater Success: :commit_hash',
    'subject_error'   => ':site_name Self-Updater ERROR',

    'email_auto_success'   => 'The :site_name Self-Updater was triggered automatically in response to code push (via web hook) and the update was successful.',
    'email_auto_failure'   => 'The :site_name Self-Updater was triggered automatically in response to code push (via web hook) and the update FAILED.',
    'email_manual_success' => 'The :site_name Self-Updater was triggered manually and the update was successful.',
    'email_manual_failure' => 'The :site_name Self-Updater was triggered manually and the update FAILED.',

    'email_error_label'   => 'ERROR: ',
    'email_unknown_error' => 'Unknown error',

    'email_git_pull' => 'Raw "git pull" output:',
    'email_commits'  => 'Commits pulled:',
    'email_migrate'  => 'Raw "php artisan migrate" output:',
);