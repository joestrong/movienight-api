<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
];
