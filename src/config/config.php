<?php

return array(
    'routes' => array(
        'manual' => '/trigger_update', // url for GET manual trigger      DEFAULT: /trigger_update
        'auto'   => '/trigger_update', // url for POST automatic trigger  DEFAULT: /trigger_update

        'manual_filter' => null, // filter for manual trigger route (e.g. if you want to 'auth.admin' first)  DEFAULT: <none>
    ),

    'branch'             => 'master', // branch to listen for pushes for and to pull from  DEFAULT: master
    'site_name'          => null,     // site name - used in various display functions     DEFAULT: $_SERVER['SERVER_NAME']
    'commit_hash_length' => 7,        // length limit for commit hash (0 for full hash)    DEFAULT: 0

  //'email' => false, //false to disable email notifications
    'email' => array(
        // from info for notification email  DEFAULT: as specified in app/config/mail.php; or <site_name> Self Updater <update@$_SERVER['SERVER_NAME']>
        'from'     => array('address' => 'update@example.com', 'name' => 'Sample Self-Updater'),
        'to'       => 'update-notify@example.com', // target for notification email  REQUIRED
        'reply_to' => 'dev-team@example.com',      // reply-to for notification email  DEFAULT: <from>

        //subject can be a static string, or a callback (or either split out into success/failure subject lines)
      //'subject'  => 'Self-Updater was triggered',
      //'subject'  => function($site_name, $success, $commit_hash) { return $site_name . ' Self-Updater ' . ($success ? 'Success: ' . $commit_hash : 'ERROR'); },
        'subject'  => array(
            'success' => 'Self-Updater success', // can also be callback function like above
            'failure' => 'Self-Updater failure',
        ),
    ),
);
