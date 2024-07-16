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
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (! defined('HEXAGONAL_PATH')) {
            define('HEXAGONAL_PATH', realpath(__DIR__.'/../../'));
        }

        $this->configure();
    }

    /**
     * Setup the configuration for Horizon.
     *
     * @return void
     */
    protected function configure(): void
    {
        // Configuración - Mergear la configuración del paquete con la configuración de la aplicación, solo hará falta publicar si queremos sobreescribir alguna configuración
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(HEXAGONAL_PATH.'/config/hexagonal.php', 'hexagonal');

            HexagonalService::setLogChannels();
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
        $this->registerTranslations();

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
                'prefix' => 'hexagonal',
            ], function () {
                $this->loadRoutesFrom(HEXAGONAL_PATH.'/routes/web.php');
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
        // $this->loadViewsFrom(HEXAGONAL_PATH.'/resources/views', 'hexagonal');
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
                    HEXAGONAL_PATH.'/database/migrations' => database_path('migrations'),
                ], 'hexagonal-migrations');
            }

            // Vistas
            /* $this->publishes([
                 HEXAGONAL_PATH.'/resources/views' => base_path('resources/views/vendor/hexagonal'),
             ], 'hexagonal-views');*/

            // Config
            $this->publishes([
                HEXAGONAL_PATH.'/config/hexagonal.php' => config_path('hexagonal.php'),
            ], 'hexagonal-config');

            // Traducciones
            if ($this->versionIsEqualOrGreaterThan9()) {
                $langPath = $this->app->langPath('vendor/hexagonal');
            } else {
                $langPath = $this->app->resourcePath('lang/vendor/hexagonal');
            }
            $this->publishes([
                HEXAGONAL_PATH.'/lang' => $langPath,
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
        $this->commands([
            ClearAll::class,
            JobDispatch::class,
            LogsClear::class,
            ServiceCheck::class,
        ]);
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
            $this->loadMigrationsFrom(HEXAGONAL_PATH.'/database/migrations');
        }
    }

    /**
     * Register Package's migration files.
     *
     * @return void
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(HEXAGONAL_PATH.'/lang', 'hexagonal');
        $this->loadJsonTranslationsFrom(HEXAGONAL_PATH.'/lang');
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
