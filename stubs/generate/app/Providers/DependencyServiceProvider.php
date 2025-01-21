<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Shared\Domain\Services\RepositoryServices\LayoutService;

final class DependencyServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        'layoutService' => LayoutService::class,
    ];
}