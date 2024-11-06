<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Services\RepositoryServices\LayoutService;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ClearAll;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\JobDispatch;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\LogsClear;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ServiceCheck;
use Thehouseofel\Hexagonal\Infrastructure\Repositories\StateEloquentRepository;
use Thehouseofel\Hexagonal\Infrastructure\Services\Hexagonal;
use Throwable;

class HexagonalServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        'layoutService' => LayoutService::class,
        StateRepositoryContract::class => StateEloquentRepository::class,
    ];

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

            Hexagonal::setLogChannels();
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
        $this->registerComponents();
        $this->registerBladeDirectives();

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
        if (Hexagonal::shouldRegistersRoutes()) {
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
        $this->loadViewsFrom(HEXAGONAL_PATH.'/resources/views', 'hexagonal');
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
            if (Hexagonal::shouldRegistersRoutes()) {
                $publishesMigrationsMethod = method_exists($this, 'publishesMigrations')
                    ? 'publishesMigrations'
                    : 'publishes';

                $this->{$publishesMigrationsMethod}([
                    HEXAGONAL_PATH.'/database/migrations' => database_path('migrations'),
                ], 'hexagonal-migrations');
            }

            // Vistas
            $this->publishes([
                HEXAGONAL_PATH.'/resources/views' => base_path('resources/views/vendor/hexagonal'),
            ], 'hexagonal-views');

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
            Hexagonal::shouldRunMigrations() &&
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
     * Register Package's components files.
     *
     * @return void
     */
    protected function registerComponents(): void
    {
        // Registrar componentes con Clase
        Blade::componentNamespace('Thehouseofel\\Hexagonal\\Infrastructure\\View\\Components', 'hexagonal');

        // Registrar componentes anónimos
        Blade::anonymousComponentPath(HEXAGONAL_PATH.'/resources/views/components', 'hexagonal');
    }

    /**
     * Register Package's Blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('viteAsset', function ($path) {
            $path = trim($path, '\'\"'); // Quita comillas alrededor del string
            try {
                return Vite::asset($path);
            } catch (Throwable $e) {
                return "";
            }
        });
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
