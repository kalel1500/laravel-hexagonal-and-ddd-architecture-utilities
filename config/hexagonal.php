<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Real environment during testing
    |--------------------------------------------------------------------------
    |
    | It is equivalent to the 'app.env' that you are in when doing the tests,
    | since during the tests the value of 'app.env' testing.
    |
    */

    'real_env_in_tests' => env('HEXAGONAL_REAL_ENV_IN_TESTS', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | The following options are used to configure the emails. If the sending
    | of emails is active, if the tests and the test recipients are active.
    |
    */

    'mail_is_active' => (bool) env('HEXAGONAL_MAIL_IS_ACTIVE', false),

    'mail_active_tests' => (bool) env('HEXAGONAL_MAIL_ACTIVE_TESTS', false),

    'mail_test_recipients' => env('HEXAGONAL_MAIL_TEST_RECIPIENTS'),

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | With this option you can activate or deactivate broadcasting.
    |
    */

    'broadcasting_enabled' => (bool) env('HEXAGONAL_BROADCASTING_ENABLED'),

    /*
    |--------------------------------------------------------------------------
    | Jobs
    |--------------------------------------------------------------------------
    |
    | In the following array you can define the namespaces of the jobs of
    | other packages that you want to be able to launch with the command
    | job:dispatch {job}.
    |
    */

    'job_paths_from_other_packages' => [],
];
