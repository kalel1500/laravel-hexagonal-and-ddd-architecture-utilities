<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractJsonVo;

class JsonStrictNullVo extends ContractJsonVo
{
    protected $nullable                = true;
    protected $allowStringInformatable = false;
}
