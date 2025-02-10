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

    'entity_class' => env('HEXAGONAL_ENTITY_CLASS', \Src\Shared\Domain\Objects\Entities\UserEntity::class),
];
