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

    'entity_class' => \Src\Shared\Domain\Objects\Entities\UserEntity::class,

    'user_repository_class' => \Src\Shared\Infrastructure\Repositories\Eloquent\UserRepository::class,

    'load_roles' => (bool) env('KALION_AUTH_LOAD_ROLES', true),
];
