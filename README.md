Laravel Self-Updater
====================

This provides automatic self-update functionality for Laravel 4.x projects using git with a central git server that supports webhooks (like Github or Gitlab).

What it does
------------
The updater is triggered by a POST request executed by the git server when a push occurs. Once triggered it does:
 1. Checks that the push was to the branch it is configured for
 2. Checks tree status to make sure it is clean before pulling
 3. Execute `git pull`.
 4. Get the current commit hash (for display purposes)
 5. Get the list of commits pulled.
 6. Rebuild optimized class file (`clear-compiled`, `dump-autoload`, `optimize`)
 7. Run all migrations
 8. Optionally notify of the update status by email

Requirements
------------
 * Laravel 4.x
 * Your git project in a git repository that has webhooks
 * git installed on the web server

Install
-------
Require this package in your composer.json and run composer update (or run `composer require vetruvet/laravel-self-updater:dev-master` directly):

    "vetruvet/laravel-self-updater": "dev-master"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

```php
'Vetruvet\LaravelSelfUpdater\SelfUpdaterServiceProvider',
```

Configure
---------
To customize the configuration, run the following command:
```
$ php artisan config:publish vetruvet/laravel-self-updater
```

Configuration options:
```php
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

```

To customize the update notification email, run the following command:
```
$ php artisan view:publish vetruvet/laravel-self-updater
```

Now, set up the webhook in your git server to point to the route specified in the configuration (`/trigger_update` by default) and you're done!

Planned Features
----------------
 * Update composer packages after pull (requires composer.lock to be committed)
 * Restart queue daemon(s) and other background stuff (somehow, no idea how yet).

Feature suggestions are welcome and much appreciated.