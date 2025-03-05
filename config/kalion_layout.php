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

    'theme' => env('KALION_LAYOUT_THEME'),

    'active_shadows' => (bool) env('KALION_LAYOUT_ACTIVE_SHADOWS', false),

    'sidebar_collapsed' => (bool) env('KALION_LAYOUT_SIDEBAR_COLLAPSED', false),

    'sidebar_state_per_page' => (bool) env('KALION_LAYOUT_SIDEBAR_STATE_PER_PAGE', false),

    'blade_show_main_border' => (bool) env('KALION_LAYOUT_BLADE_SHOW_MAIN_BORDER', false),
];
