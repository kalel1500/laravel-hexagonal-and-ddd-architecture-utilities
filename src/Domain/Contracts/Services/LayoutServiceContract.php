<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Services;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Layout\NavbarItemCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\UserInfoDo;

interface LayoutServiceContract
{
    public function getMessageCounter(): int;
    public function getNavbarNotifications(): NavbarItemCollection;
    public function getUserInfo(): UserInfoDo;
}