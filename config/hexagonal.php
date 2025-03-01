<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Route
    |--------------------------------------------------------------------------
    |
    | The following options allow you to configure the default route to which
    | the application should redirect you
    |
    */

    'default_route' => env('HEXAGONAL_DEFAULT_ROUTE', '/home'),

    'default_route_name' => env('HEXAGONAL_DEFAULT_ROUTE_NAME', 'home'),

    /*
    |--------------------------------------------------------------------------
    | Real environment during testing
    |--------------------------------------------------------------------------
    |
    | It is equivalent to the 'app.env' that you are in when doing the tests,
    | since during the tests the value of 'app.env' testing.
    |
    */

    'fake_login_active' => (bool) env('HEXAGONAL_FAKE_LOGIN_ACTIVE', false),

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

    'broadcasting_enabled' => (bool) env('HEXAGONAL_BROADCASTING_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Calculated properties of entities
    |--------------------------------------------------------------------------
    |
    | With this option you can configure how entity relationships should behave
    | by default. When you instantiate an entity with relationships, each entity
    | can be generated in a simple way with only its basic properties or in a
    | complete way by adding the calculated properties. This can be indicated every
    | time an entity is created as a third parameter and also in the relationships
    | with the flag 's' (simple) or 'f' (full).
    |
    | With this option you can indicate how entities should behave by default.
    |
    | Supported values: "f", "s"
    |
    */

    'entity_calculated_props_mode' => env('HEXAGONAL_ENTITY_CALCULATED_PROPS_MODE', 's'),

    /*
    |--------------------------------------------------------------------------
    | ModelId value object
    |--------------------------------------------------------------------------
    |
    | The following option allows you to configure the minimum value allowed
    | in the Value Object "ModelId"
    |
    */

    'minimum_value_for_model_id' => (int) env('HEXAGONAL_MINIMUM_VALUE_FOR_MODEL_ID', 1),

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

    /*
    |--------------------------------------------------------------------------
    | Cookies
    |--------------------------------------------------------------------------
    |
    | The next option allows you to set the cookie package prefix and duration.
    |
    */

    'cookie' => [
        'name' => Str::slug(env('APP_NAME', 'laravel'), '_').'_hexagonal_user_preferences',
        'duration' => (int) env('HEXAGONAL_COOKIE_DURATION', (60 * 24 * 364)),
        'version' => env('HEXAGONAL_COOKIE_VERSION', "0"),
    ],

    /*
    |--------------------------------------------------------------------------
    | NPM dependency versions of the Start command
    |--------------------------------------------------------------------------
    |
    | With these options you can configure which versions of npm dependencies
    | will be installed in the application.
    |
    */

    'version_flowbite' => '^2.5.2',

    'version_types_node' => '^22.10.10',

    'version_prettier' => '^3.4.2',

    'version_prettier_plugin_blade' => '^2.1.19',

    'version_prettier_plugin_tailwindcss' => '^0.6.11',

    'version_typescript' => '^5.7.3',

    'version_kalel1500_laravel_ts_utils' => '^0.5.0-beta.0',

    'version_node' => '^20.11.1',

    'version_npm' => '^10.5.0',

    'version_tabulator_tables' => '^6.3.1',

    /*
    |--------------------------------------------------------------------------
    | Package in develop
    |--------------------------------------------------------------------------
    |
    | With this option you can configure if the package is in development to
    | avoid executing unnecessary methods in the "hexagonal:start" command.
    |
    */

    'package_in_develop' => (bool) env('HEXAGONAL_PACKAGE_IN_DEVELOP', false),
    'keep_migrations_date' => (bool) env('HEXAGONAL_KEEP_MIGRATIONS_DATE', false),
];
