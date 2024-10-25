<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Layout\NavbarItemCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\UserInfoDo;

/**
 * @method static int getMessageCounter()
 * @method static NavbarItemCollection getNavbarNotifications()
 * @method static UserInfoDo getUserInfo()
 */
final class LayoutService extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'layoutService';
    }
}