<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout;

use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;

final class UserInfoDo extends ContractDataObject
{
    public $name;
    public $email;

    public function __construct(
        string $name,
        string $email
    )
    {
        $this->name = $name;
        $this->email = $email;
    }
}