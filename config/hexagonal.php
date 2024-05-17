<?php

return [
    'mail_is_active'        => (bool)   env('HEXAGONAL_MAIL_IS_ACTIVE', false),
    'mail_active_tests'     => (bool)   env('HEXAGONAL_MAIL_ACTIVE_TESTS', false),
    'mail_test_recipients'  =>          env('HEXAGONAL_MAIL_TEST_RECIPIENTS'),
    'real_env_in_tests'     =>          env('HEXAGONAL_REAL_ENV_IN_TESTS', 'local'),
    'broadcasting_enabled'  => (bool)   env('HEXAGONAL_BROADCASTING_ENABLED'),

    'job_paths_from_other_packages' => []
];
