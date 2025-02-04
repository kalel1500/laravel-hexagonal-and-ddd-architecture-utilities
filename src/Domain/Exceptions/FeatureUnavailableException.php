<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Thehouseofel\Hexagonal\Domain\Exceptions\Base\BasicException;

final class FeatureUnavailableException extends BasicException
{
    const STATUS_CODE = 500;

    public function __construct()
    {
        parent::__construct(__('error_featureUnavailable'));
    }
}
