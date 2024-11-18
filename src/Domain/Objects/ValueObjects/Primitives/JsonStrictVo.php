<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractJsonVo;

class JsonStrictVo extends ContractJsonVo
{
    protected $nullable                = false;
    protected $allowStringInformatable = false;
}
