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

    'entity_class' => env('HEXAGONAL_AUTH_ENTITY_CLASS', \Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity::class),

    'load_roles' => (bool) env('HEXAGONAL_AUTH_LOAD_ROLES', true),
];
