<?php

use Illuminate\Support\Str;

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
    | Layout
    |--------------------------------------------------------------------------
    |
    | In the following options you can configure the layout options.
    |
    */

    'blade_show_main_border' => (bool) env('HEXAGONAL_BLADE_SHOW_MAIN_BORDER', false),

    'dark_theme' => (bool) env('HEXAGONAL_DARK_THEME', false),

    'sidebar_collapsed' => (bool) env('HEXAGONAL_SIDEBAR_COLLAPSED', false),

    'sidebar_state_per_page' => (bool) env('HEXAGONAL_SIDEBAR_STATE_PER_PAGE', false),

    'navbar' => [
        'search' => [
            'show' => true,
            'route' => null,
        ],
        'items' => [
            [
                'code'              => 'notifications',
                'icon'              => 'hexagonal::icon.bell',
                'text'              => 'View notifications',
                'tooltip'           => null,
                'route_name'        => null,
                'is_theme_toggle'   => false,
                'is_user'           => false,
                'dropdown'          => [
                    'is_list'           => true,
                    'is_square'         => false,
                    'get_data_action'   => 'getNavbarNotifications',
                    'header'            => 'Notifications',
                    'footer'            => [
                        'icon'       => 'hexagonal::icon.eye',
                        'text'       => 'View all',
                        'route_name' => null,
                    ],
                ],
            ],
            [
                'code'              => 'apps',
                'icon'              => 'hexagonal::icon.squares-2x2',
                'text'              => 'View other links of the application',
                'tooltip'           => null,
                'route_name'        => null,
                'is_theme_toggle'   => false,
                'is_user'           => false,
                'dropdown'          => [
                    'is_list'           => false,
                    'is_square'         => true,
                    'get_data_action'   => null,
                    'header'            => 'Apps',
                    'footer'            => null,
                    'items'             => [
                        [
                            'icon'          => 'hexagonal::icon.shopping-bag',
                            'text'          => 'Sales',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.user-group',
                            'text'          => 'Users',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.inbox',
                            'text'          => 'Inbox',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.user-circle',
                            'text'          => 'Profile',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.cog-8-tooth',
                            'text'          => 'Settings',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.archive-box',
                            'text'          => 'Products',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.currency-dollar',
                            'text'          => 'Pricing',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.receipt-percent',
                            'text'          => 'Billing',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.arrow-left-end-on-rectangle',
                            'text'          => 'Logout',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                    ]
                ],
            ],
            [
                'is_theme_toggle'   => true,
            ],
            [
                'code'              => 'user',
                'icon'              => null,
                'text'              => 'Open user menu',
                'tooltip'           => null,
                'route_name'        => null,
                'is_theme_toggle'   => false,
                'is_user'           => true,
                'dropdown'          => [
                    'is_list'           => false,
                    'is_square'         => false,
                    'get_data_action'   => 'getUserInfo',
                    'header'            => null,
                    'footer'            => null,
                    'items'             => [
                        [
                            'icon'          => null,
                            'text'          => 'My profile',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => null,
                            'text'          => 'Account settings',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'is_separator'  => true,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.heart',
                            'text'          => 'My likes',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.rectangle-stack',
                            'text'          => 'Collections',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'hexagonal::icon.fire;text-blue-600 dark:text-blue-500',
                            'text'          => 'Pro version',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'is_separator'  => true,
                        ],
                        [
                            'icon'          => '',
                            'text'          => 'Sign out',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                    ],
                ],
            ],
        ],
    ],

    'sidebar' => [
        'search' => [
            'show' => true,
            'route' => null,
        ],
        'items' => [
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.chart-pie',
                'text'              => 'Overview',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.document-text',
                'text'              => 'Pages',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'code'              => null,
                        'text'              => 'Settings',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Kanban',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Calendar',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.shopping-bag',
                'text'              => 'Sales',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'code'              => null,
                        'text'              => 'Products',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Billing',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Invoice',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.inbox-arrow-down',
                'text'              => 'Messages',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => 'getMessageCounter',
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.lock-closed',
                'text'              => 'Authentication',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'code'              => null,
                        'text'              => 'Sign In',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Sign Up',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Forgot Password',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
            //----- is_separator -----------------------------
            [
                'is_separator' => true,
            ],
            //----- end is_separator -----------------------------
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.clipboard-document-list',
                'text'              => 'Docs',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.rectangle-stack',
                'text'              => 'Components',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.lifebuoy',
                'text'              => 'Help',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.document-text',
                'text'              => 'Hexagonal',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'code'              => 'h-pages',
                        'text'              => 'Pages',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                        'dropdown'          => [
                            [
                                'code'              => null,
                                'text'              => 'Laravel Welcome',
                                'tooltip'           => null,
                                'route_name'        => 'welcome',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Root',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.root',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Queued Jobs (Pending)',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.queues.queuedJobs',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Failed Jobs (Pending)',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.queues.failedJobs',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Compare Html',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.compareHtml',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Update Cookie',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.modifyCookie',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Icons',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.icons',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                        ]
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Examples',
                        'tooltip'           => null,
                        'route_name'        => null,
                        'counter_action'    => null,
                        'collapsed'         => false,
                        'dropdown'          => [
                            [
                                'code'              => null,
                                'text'              => 'Example 1',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.example1',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Example 2',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.example2',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Example 3',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.example3',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                            [
                                'code'              => null,
                                'text'              => 'Example 4',
                                'tooltip'           => null,
                                'route_name'        => 'hexagonal.example4',
                                'counter_action'    => null,
                                'collapsed'         => false,
                            ],
                        ]
                    ],
                ],
            ],
        ],
        'footer' => [
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.adjustments-vertical',
                'text'              => null,
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => 'settings',
                'icon'              => 'hexagonal::icon.cog-8-tooth',
                'text'              => null,
                'tooltip'           => 'Settings page',
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => 'language',
                'icon'              => 'hexagonal::icon.flag.us-1',
                'text'              => null,
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'icon'              => 'hexagonal::icon.flag.us-2',
                        'text'              => 'English (US)',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => 'hexagonal::icon.flag.de',
                        'text'              => 'Deutsch',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => 'hexagonal::icon.flag.it',
                        'text'              => 'Italiano',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => 'hexagonal::icon.flag.cn',
                        'text'              => '中文 (繁體)',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Package in develop
    |--------------------------------------------------------------------------
    |
    | With this option you can configure if the package is in development to
    | avoid executing unnecessary methods in the "hexagonal:start" command.
    |
    */

    'package_in_develop' => false,
];
