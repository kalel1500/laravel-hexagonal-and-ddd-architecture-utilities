<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Services\RepositoryServices;

use Thehouseofel\Hexagonal\Domain\Contracts\Services\LayoutServiceContract;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Layout\NavbarItemCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\UserInfoDo;

final class LayoutService implements LayoutServiceContract
{
    public function getMessageCounter(): int
    {
        return 4;
    }

    public function getNavbarNotifications(): NavbarItemCollection
    {
        return NavbarItemCollection::fromArray([
            [
                'icon'  => 'hexagonal::icon.user-profile',
                'text'  => 'New message from Bonnie Green: "Hey, what\'s up? All set for the presentation?"',
                'time'  => 'a few moments ago',
            ],
            [
                'icon'  => 'hexagonal::icon.user-profile',
                'text'  => 'Jese leos and 5 others started following you.',
                'time'  => '10 minutes ago',
            ],
            [
                'icon'  => 'hexagonal::icon.user-profile',
                'text'  => 'Joseph Mcfall and 141 others love your story. See it and view more stories.',
                'time'  => '44 minutes ago',
            ],
            [
                'icon'  => 'hexagonal::icon.user-profile',
                'text'  => 'Leslie Livingston mentioned you in a comment: @bonnie.green what do you say?',
                'time'  => '1 hour ago',
            ],
            [
                'icon'  => 'hexagonal::icon.user-profile',
                'text'  => 'Robert Brown posted a new video: Glassmorphism - learn how to implement the new design trend.',
                'time'  => '3 hours ago',
            ],
        ]);
    }

    public function getUserInfo(): UserInfoDo
    {
        return UserInfoDo::fromArray([
            'name' => 'Neil Sims',
            'email' => 'name@flowbite.com'
        ]);
    }
}
