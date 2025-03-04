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

    'theme' => env('HEXAGONAL_LAYOUT_THEME'),

    'active_shadows' => (bool) env('HEXAGONAL_LAYOUT_ACTIVE_SHADOWS', false),

    'sidebar_collapsed' => (bool) env('HEXAGONAL_LAYOUT_SIDEBAR_COLLAPSED', false),

    'sidebar_state_per_page' => (bool) env('HEXAGONAL_LAYOUT_SIDEBAR_STATE_PER_PAGE', false),

    'blade_show_main_border' => (bool) env('HEXAGONAL_LAYOUT_BLADE_SHOW_MAIN_BORDER', false),
];
