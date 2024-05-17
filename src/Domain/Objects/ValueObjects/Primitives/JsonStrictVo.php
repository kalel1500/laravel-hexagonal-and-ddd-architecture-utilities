<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractJsonVo;

class JsonStrictVo extends ContractJsonVo
{
    protected $allowNull = false;
    protected $allowStringInformatable = false;
}
