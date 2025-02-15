<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | In the following options you can configure the layout options.
    |
    */

    'dark_theme' => (bool) env('HEXAGONAL_LAYOUT_DARK_THEME', false),

    'active_shadows' => (bool) env('HEXAGONAL_LAYOUT_ACTIVE_SHADOWS', false),

    'sidebar_collapsed' => (bool) env('HEXAGONAL_LAYOUT_SIDEBAR_COLLAPSED', false),

    'sidebar_state_per_page' => (bool) env('HEXAGONAL_LAYOUT_SIDEBAR_STATE_PER_PAGE', false),

    'navbar' => [
        'search' => [
            'show' => false,
            'route' => null,
        ],
        'items' => [
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
                            'icon'          => 'hexagonal::icon.arrow-left-end-on-rectangle',
                            'text'          => 'Log Out',
                            'tooltip'       => null,
                            'route_name'    => 'logout',
                            'is_post'       => true,
                            'is_separator'  => false,
                        ],
                    ],
                ],
            ],
        ],
    ],

    'sidebar' => [
        'search' => [
            'show' => false,
            'route' => null,
        ],
        'items' => [
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.computer-desktop',
                'text'              => 'Welcome',
                'tooltip'           => null,
                'route_name'        => 'welcome',
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.home',
                'text'              => 'Home',
                'tooltip'           => null,
                'route_name'        => 'home',
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.document-text',
                'text'              => 'Dashboard',
                'tooltip'           => null,
                'route_name'        => 'dashboard',
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
            [
                'code'              => null,
                'icon'              => 'hexagonal::icon.tag',
                'text'              => 'Tags',
                'tooltip'           => null,
                'route_name'        => 'tags',
                'counter_action'    => null,
                'collapsed'         => false,
                'is_separator'      => false,
                'dropdown'          => null,
            ],
        ],
    ],

    'blade_show_main_border' => (bool) env('HEXAGONAL_LAYOUT_BLADE_SHOW_MAIN_BORDER', false),
];
