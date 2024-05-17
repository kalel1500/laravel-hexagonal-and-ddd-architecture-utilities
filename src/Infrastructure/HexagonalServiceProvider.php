<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Thehouseofel\Hexagonal\Domain\Services\HexagonalService;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ClearAll;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\JobDispatch;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\LogsClear;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ServiceCheck;

class HexagonalServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        // Configuración - con el merge, solo hará falta publicar si queremos sobreescribir alguna configuración
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../../config/hexagonal.php', 'hexagonal');
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->registerPublishing();
        $this->registerCommands();
        $this->registerMigrations();

        // Middlewares
//        $router = $this->app->make(Router::class);
//        $router->aliasMiddleware('hexagonal.anyMiddleware', HexagonalAnyMiddleware::class);
    }

    /**
     * Register the Package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        if (HexagonalService::shouldRegistersRoutes()) {
            Route::group([
                'as' => 'hexagonal.',
                'prefix' => config('hexagonal.path', 'hexagonal'),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
            });
        }
    }

    /**
     * Register the Package resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'hexagonal');
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {

            // Migraciones
            if (HexagonalService::shouldRegistersRoutes()) {
                $publishesMigrationsMethod = method_exists($this, 'publishesMigrations')
                    ? 'publishesMigrations'
                    : 'publishes';

                $this->{$publishesMigrationsMethod}([
                    __DIR__.'/../../database/migrations' => database_path('migrations'),
                ], 'hexagonal-migrations');
            }

            // Vistas
            /* $this->publishes([
                 __DIR__.'/../../resources/views' => base_path('resources/views/vendor/hexagonal'),
             ], 'hexagonal-views');*/

            // Config
            $this->publishes([
                __DIR__.'/../../config/hexagonal.php' => config_path('hexagonal.php'),
            ], 'hexagonal-config');

            // Traducciones
            if ($this->versionIsEqualOrGreaterThan9()) {
                $langPath = $this->app->langPath('vendor/hexagonal');
            } else {
                $langPath = $this->app->resourcePath('lang/vendor/hexagonal');
            }
            $this->publishes([
                __DIR__.'/../../lang' => $langPath,
            ], 'hexagonal-lang');
        }
    }

    /**
     * Register the Package Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearAll::class,
                JobDispatch::class,
                LogsClear::class,
                ServiceCheck::class,
            ]);
        }
    }

    /**
     * Register Package's migration files.
     *
     * @return void
     */
    protected function registerMigrations(): void
    {
        if (
            $this->app->runningInConsole() &&
            HexagonalService::shouldRunMigrations() &&
            $this->versionIsEqualOrGreaterThan9()
        ) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        }
    }

    /**
     * Register Package's migration files.
     *
     * @return void
     */
    protected function registerTranslations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadTranslationsFrom(__DIR__.'/../../lang', 'hexagonal');
            $this->loadJsonTranslationsFrom(__DIR__.'/../../lang');
        }
    }


    /**
     * Determinar si la version de laravel instalada es mayor a la 9
     *
     * @return bool
     */
    private function versionIsEqualOrGreaterThan9(): bool
    {
        return version_compare($this->app->version(), '9', '>=');
    }
}
