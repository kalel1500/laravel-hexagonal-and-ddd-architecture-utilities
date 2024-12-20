<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Services\RepositoryServices\LayoutService;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ClearAll;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\HexagonalStart;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\JobDispatch;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\LogsClear;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ServiceCheck;
use Thehouseofel\Hexagonal\Infrastructure\Repositories\StateEloquentRepository;
use Thehouseofel\Hexagonal\Infrastructure\Services\Hexagonal;

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
        $this->registerMiddlewares();
        $this->registerMacros();
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
                'middleware' => 'web',
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
            if (Hexagonal::shouldRunMigrations()) {
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
                HEXAGONAL_PATH.'/src/Infrastructure/View/Components' => app_path('View/Components'),
            ], 'hexagonal-views');

            // Publicar solo la vista "app.blade.php"
            $this->publishes([
                HEXAGONAL_PATH.'/resources/views/components/layout/app.blade.php' => base_path('resources/views/vendor/hexagonal/components/layout/app.blade.php'),
                HEXAGONAL_PATH.'/src/Infrastructure/View/Components/Layout/App.php' => app_path('View/Components/Layout/App.php'),
            ], 'hexagonal-view-layout');

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
            HexagonalStart::class,
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
            return "<?php 
                try {
                    echo e(\\Illuminate\\Support\\Facades\\Vite::asset(trim($path, '\'\"')));
                } catch (\\Throwable \$e) {
                    echo e(\$e->getMessage()); 
                }
            ?>";
        });
    }

    /**
     * Register Package's Middlewares.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function registerMiddlewares(): void
    {
//        /** @var Router $router */
//        $router = $this->app->make(Router::class);

        // Registrar un grupo de middlewares
//        $router->middlewareGroup('web', [\Vendor\Package\Http\Middleware\HexagonalAnyMiddleware::class]);

        // Registrar middlewares solo para rutas específicas
//        $router->aliasMiddleware('hexagonal.anyMiddleware', HexagonalAnyMiddleware::class);

        // Añadir un middleware a un grupo (con Router para soportar versiones anteriores a la 6)
//        $router->pushMiddlewareToGroup('web', ShareInertiaData::class);

        // Añadir un middleware a un grupo (con Router para soportar versiones posteriores a la 6)
        if (Hexagonal::enabledPreferencesCookie()) {
            /** @var Kernel $kernel */
            $kernel = $this->app->make(Kernel::class);
            $kernel->appendMiddlewareToGroup('web', \Thehouseofel\Hexagonal\Infrastructure\Http\Middleware\AddPreferencesCookies::class);

            // Desencriptar las cookies de las preferencias del usuario
            $this->app->booted(function () {
                /** @var EncryptCookies $encryptCookies */
                $encryptCookies = $this->app->make(EncryptCookies::class);
                $encryptCookies::except(config('hexagonal.cookie.name')); // laravel_hexagonal_user_preferences
            });
        }
    }

    /**
     * Add Package's Macros.
     *
     * @return void
     */
    protected function registerMacros(): void
    {
        ComponentAttributeBag::macro('mergeTailwind', function ($defaultClasses) {
            /** @var ComponentAttributeBag $this */

            // Obtiene las clases personalizadas
            $customClasses = $this->get('class', '');

            // Divide ambas cadenas en arrays
            $defaultArray = explode(' ', $defaultClasses);
            $customArray = explode(' ', $customClasses);

            // Filtra las clases del default eliminando conflictos con las custom
            $filteredDefault = array_filter($defaultArray, function ($class) use ($customArray) {
                $prefix = strtok($class, '-'); // Obtén el prefijo de la clase, como "p"
                return !Arr::first($customArray, function ($customClass) use ($prefix) { return str_starts_with($customClass, $prefix); });
            });

            // Genera las clases finales
            //$finalClasses = implode(' ', $filteredDefault) . ' ' . $customClasses;

            // Llama al método `merge` de la clase original
            return $this->merge(['class' => implode(' ', $filteredDefault)]);
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
