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

    'entity_class' => \Src\Shared\Domain\Objects\Entities\UserEntity::class,

    /*
    |--------------------------------------------------------------------------
    | Repository class
    |--------------------------------------------------------------------------
    |
    | In the following option you can configure the user Repository class.
    |
    */

    'user_repository_class' => \Src\Shared\Infrastructure\Repositories\Eloquent\UserRepository::class,

];
