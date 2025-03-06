<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entity class
    |--------------------------------------------------------------------------
    |
    | In the following option you can configure the user entity class.
    |
    */

    'entity_class' => env('KALION_AUTH_ENTITY_CLASS', \Src\Shared\Domain\Objects\Entities\UserEntity::class),

    'user_repository_class' => env('KALION_AUTH_ENTITY_CLASS', \Src\Shared\Infrastructure\Repositories\Eloquent\UserRepository::class),

    'load_roles' => (bool) env('KALION_AUTH_LOAD_ROLES', true),
];
