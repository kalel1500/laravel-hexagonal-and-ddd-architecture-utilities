<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entity class
    |--------------------------------------------------------------------------
    |
    | In the following option you can configure the user Entity class.
    |
    */

    'entity_class' => env('KALION_AUTH_ENTITY_CLASS', \Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity::class),

    /*
    |--------------------------------------------------------------------------
    | Repository class
    |--------------------------------------------------------------------------
    |
    | In the following option you can configure the user Repository class.
    |
    */

    'user_repository_class' => env('KALION_AUTH_ENTITY_CLASS', \Thehouseofel\Hexagonal\Infrastructure\Repositories\UserRepository::class),

    /*
    |--------------------------------------------------------------------------
    | Load user roles
    |--------------------------------------------------------------------------
    |
    | With the following option you can configure whether the roles of
    | the authenticated user are automatically loaded
    |
    */

    'load_roles' => (bool) env('KALION_AUTH_LOAD_ROLES', true),

    /*
    |--------------------------------------------------------------------------
    | Display role in exception
    |--------------------------------------------------------------------------
    |
    | When set to true, the required role names are added to exception messages.
    | This could be considered an information leak in some contexts, so the default
    | setting is false here for optimum safety.
    |
    */

    'display_role_in_exception' => (bool) env('KALION_AUTH_DISPLAY_ROLE_IN_EXCEPTION', false),

    /*
    |--------------------------------------------------------------------------
    | Display role in exception
    |--------------------------------------------------------------------------
    |
    | When set to true, the required permission names are added to exception messages.
    | This could be considered an information leak in some contexts, so the default
    | setting is false here for optimum safety.
    |
    */

    'display_permission_in_exception' => (bool) env('KALION_AUTH_DISPLAY_PERMISSION_IN_EXCEPTION', false),
];
