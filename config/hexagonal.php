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
    | Layout
    |--------------------------------------------------------------------------
    |
    | In the following options you can configure the layout options.
    |
    */

    'blade_show_main_border' => (bool) env('HEXAGONAL_BLADE_SHOW_MAIN_BORDER', false),

    'navbar' => [
        'search' => [
            'show' => true,
            'route' => null,
        ],
        'items' => [
            [
                'code'              => 'notifications',
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>',
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
                        'icon'       => '<svg aria-hidden="true" class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        'text'       => 'View all',
                        'route_name' => null,
                    ],
                ],
            ],
            [
                'code'              => 'apps',
                'icon'              => '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>',
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
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Sales',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>',
                            'text'          => 'Users',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Inbox',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Profile',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Settings',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Products',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Pricing',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'Billing',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>',
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
                            'icon'          => 'My profile',
                            'text'          => '',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => 'Account settings',
                            'text'          => '',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'is_separator'  => true,
                        ],
                        [
                            'icon'          => '<svg class="mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>',
                            'text'          => 'My likes',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg class="mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>',
                            'text'          => 'Collections',
                            'tooltip'       => null,
                            'route_name'    => null,
                            'is_separator'  => false,
                        ],
                        [
                            'icon'          => '<svg aria-hidden="true" class="text-blue-600 dark:text-blue-500 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>',
                'text'              => 'Overview',
                'tooltip'           => null,
                'route_name'        => 'hexagonal.example1',
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>',
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
                        'route_name'        => 'hexagonal.example2',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Kanban',
                        'tooltip'           => null,
                        'route_name'        => 'hexagonal.example3',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Calendar',
                        'tooltip'           => null,
                        'route_name'        => 'hexagonal.example4',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
            [
                'code'              => null,
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>',
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
                        'route_name'        => 'hexagonal.compareHtml',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Billing',
                        'tooltip'           => null,
                        'route_name'        => 'hexagonal.queues.queuedJobs',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                    [
                        'code'              => null,
                        'text'              => 'Invoice',
                        'tooltip'           => null,
                        'route_name'        => 'hexagonal.queues.failedJobs',
                        'counter_action'    => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
            [
                'code'              => null,
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path></svg>',
                'text'              => 'Help',
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
        ],
        'footer' => [
            [
                'code'              => null,
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>',
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
                'icon'              => '<svg aria-hidden="true" class="mt-0.5 h-5 w-5 rounded-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3900 3900"><path fill="#b22234" d="M0 0h7410v3900H0z"/><path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff" stroke-width="300"/><path fill="#3c3b6e" d="M0 0h2964v2100H0z"/><g fill="#fff"><g id="d"><g id="c"><g id="e"><g id="b"><path id="a" d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z"/><use xlink:href="#a" y="420"/><use xlink:href="#a" y="840"/><use xlink:href="#a" y="1260"/></g><use xlink:href="#a" y="1680"/></g><use xlink:href="#b" x="247" y="210"/></g><use xlink:href="#c" x="494"/></g><use xlink:href="#d" x="988"/><use xlink:href="#c" x="1976"/><use xlink:href="#e" x="2470"/></g></svg>',
                'text'              => null,
                'tooltip'           => null,
                'route_name'        => null,
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => [
                    [
                        'icon'              => '<svg aria-hidden="true" class="mr-2 h-3.5 w-3.5 rounded-full" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us" viewBox="0 0 512 512"><g fill-rule="evenodd"><g stroke-width="1pt"><path fill="#bd3d44" d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z" transform="scale(3.9385)"/><path fill="#fff" d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z" transform="scale(3.9385)"/></g><path fill="#192f5d" d="M0 0h98.8v70H0z" transform="scale(3.9385)"/><path fill="#fff" d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z" transform="scale(3.9385)"/></g></svg>',
                        'text'              => 'English (US)',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => '<svg aria-hidden="true" class="mr-2 h-3.5 w-3.5 rounded-full" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de" viewBox="0 0 512 512"><path fill="#ffce00" d="M0 341.3h512V512H0z"/><path d="M0 0h512v170.7H0z"/><path fill="#d00" d="M0 170.7h512v170.6H0z"/></svg>',
                        'text'              => 'Deutsch',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => '<svg aria-hidden="true" class="mr-2 h-3.5 w-3.5 rounded-full" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it" viewBox="0 0 512 512"><g fill-rule="evenodd" stroke-width="1pt"><path fill="#fff" d="M0 0h512v512H0z"/><path fill="#009246" d="M0 0h170.7v512H0z"/><path fill="#ce2b37" d="M341.3 0H512v512H341.3z"/></g></svg>',
                        'text'              => 'Italiano',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                    [
                        'icon'              => '<svg aria-hidden="true" class="mr-2 h-3.5 w-3.5 rounded-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="flag-icon-css-cn" viewBox="0 0 512 512"><defs><path id="a" fill="#ffde00" d="M1-.3L-.7.8 0-1 .6.8-1-.3z"/></defs><path fill="#de2910" d="M0 0h512v512H0z"/><use width="30" height="20" transform="matrix(76.8 0 0 76.8 128 128)" xlink:href="#a"/><use width="30" height="20" transform="rotate(-121 142.6 -47) scale(25.5827)" xlink:href="#a"/><use width="30" height="20" transform="rotate(-98.1 198 -82) scale(25.6)" xlink:href="#a"/><use width="30" height="20" transform="rotate(-74 272.4 -114) scale(25.6137)" xlink:href="#a"/><use width="30" height="20" transform="matrix(16 -19.968 19.968 16 256 230.4)" xlink:href="#a"/></svg>',
                        'text'              => '中文 (繁體)',
                        'route_name'        => null,
                        'collapsed'         => false,
                    ],
                ],
            ],
        ]
    ],
];
