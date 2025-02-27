<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Events\VendorTagPublished;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ClearAll;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\HexagonalStart;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\JobDispatch;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\LogsClear;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\ServiceCheck;
use Thehouseofel\Hexagonal\Infrastructure\Http\Middleware\UserHasPermission;
use Thehouseofel\Hexagonal\Infrastructure\Http\Middleware\UserHasRole;
use Thehouseofel\Hexagonal\Infrastructure\Services\Hexagonal;
use Thehouseofel\Hexagonal\Infrastructure\Services\Version;

class HexagonalServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        'layoutService'                                                                           => \Thehouseofel\Hexagonal\Domain\Services\RepositoryServices\LayoutService::class,
        'authService'                                                                             => \Thehouseofel\Hexagonal\Infrastructure\Services\AuthService::class,
        \Thehouseofel\Hexagonal\Domain\Contracts\Repositories\RoleRepositoryContract::class       => \Thehouseofel\Hexagonal\Infrastructure\Repositories\RoleRepository::class,
        \Thehouseofel\Hexagonal\Domain\Contracts\Repositories\PermissionRepositoryContract::class => \Thehouseofel\Hexagonal\Infrastructure\Repositories\PermissionRepository::class,
        \Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract::class      => \Thehouseofel\Hexagonal\Infrastructure\Repositories\StateEloquentRepository::class,
    ];

    /**
     * Remove the given provider from the application's provider bootstrap file.
     *
     * @param  string  $provider
     * @param  string|null  $path
     * @return bool
     */
    public static function removeProviderFromBootstrapFile(string $provider, ?string $path = null): bool
    {
        $path ??= app()->getBootstrapProvidersPath();

        if (!file_exists($path)) {
            return false;
        }

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($path, true);
        }

        // Cargar los proveedores actuales del archivo
        $providers = collect(require $path)
            ->reject(fn($p) => $p === $provider) // Eliminar el provider específico
            ->unique()
            ->sort()
            ->values()
            ->map(fn($p) => '    '.$p.'::class,') // Formatear las líneas
            ->implode(PHP_EOL);

        $content = '<?php

return [
'.$providers.'
];';

        // Escribir el contenido actualizado en el archivo
        file_put_contents($path, $content.PHP_EOL);

        return true;
    }

    private function updateNameOfMigrationsIfExist()
    {
        $filesystem = new Filesystem();
        $migrationsPath = database_path('migrations');

        // Lista de nombres de migraciones que quieres renombrar (sin timestamp)
        $migrationFiles = [
            'create_states_table',
            'create_tags_table',
            'create_posts_table',
            'create_comments_table',
            'create_post_tag_table',
        ];

        // Verificar si hay al menos una migración publicada usando coincidencia parcial
        $migrationsExist = collect($filesystem->files($migrationsPath))->some(function ($file) use ($migrationFiles) {
            return collect($migrationFiles)->contains(fn($migration) => Str::contains($file->getFilename(), $migration));
        });

        // Salir si no hay migraciones publicadas
        if (!$migrationsExist) return;

        $timestamp = now(); // Iniciar con el timestamp actual

        foreach ($filesystem->files($migrationsPath) as $file) {
            foreach ($migrationFiles as $migration) {
                if (Str::contains($file->getFilename(), $migration)) {
                    // Generar nuevo nombre con timestamp actual + nombre de la migración
                    $newName = $timestamp->format('Y_m_d_His') . '_' . $migration . '.php';

                    // Renombrar el archivo
                    $filesystem->move($file->getPathname(), $migrationsPath . '/' . $newName);

                    // Incrementar el timestamp en 1 segundo para la próxima migración
                    $timestamp->addSecond();

                    break; // Salimos del bucle interno tras encontrar la coincidencia
                }
            }
        }
    }


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

        $this->registerSingletons();
        $this->configure();
    }

    protected function registerSingletons(): void
    {
        $this->app->singleton(\Thehouseofel\Hexagonal\Domain\Contracts\Repositories\UserRepositoryContract::class, fn($app) => new (config('hexagonal_auth.user_repository_class'))());
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
            $this->mergeConfigFrom(HEXAGONAL_PATH.'/config/hexagonal_auth.php', 'hexagonal_auth');
            $this->mergeConfigFrom(HEXAGONAL_PATH.'/config/hexagonal_layout.php', 'hexagonal_layout');
            $this->mergeConfigFrom(HEXAGONAL_PATH.'/config/hexagonal_links.php', 'hexagonal_links');

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
//                'as' => 'hexagonal.',
//                'prefix' => 'hexagonal',
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
        if (!$this->app->runningInConsole()) return;

        /*
         * -------------------
         * --- Migraciones ---
         * -------------------
         */

        if (Hexagonal::shouldPublishMigrations() && Version::laravelMin9()) {
            $existNewMethod = method_exists($this, 'publishesMigrations');
            $publishesMigrationsMethod = $existNewMethod
                ? 'publishesMigrations'
                : 'publishes';

            $this->{$publishesMigrationsMethod}([
                HEXAGONAL_PATH.'/database/migrations' => database_path('migrations'),
                HEXAGONAL_PATH.'/stubs/generate/database/migrations' => database_path('migrations'),
            ], 'hexagonal-migrations');

            /*if (!$existNewMethod) {
                Event::listen(function (VendorTagPublished $event) {
                    // Definir que palabras identifican las migraciones del paquete
                    $keywords = ['laravel-hexagonal-and-ddd-architecture-utilities', 'migrations'];

                    // Buscar en las rutas publicadas si alguna contiene las 3 palabras
                    $publishedHexagonalMigrations = Arr::first(array_keys($event->paths), fn($key) => collect($keywords)->every(fn($word) => Str::contains($key, $word)));

                    // Actualizar nombres de las migraciones solo si se han ejecutado
                    if ($publishedHexagonalMigrations) {
                        $this->updateNameOfMigrationsIfExist();
                    }
                });
            }*/
        }


        /*
         * --------------
         * --- Vistas ---
         * --------------
         */

        // Todas
        $this->publishes([
            HEXAGONAL_PATH.'/resources/views' => base_path('resources/views/vendor/hexagonal'),
            HEXAGONAL_PATH.'/src/Infrastructure/View/Components' => app_path('View/Components'),
        ], 'hexagonal-views');

        // Publicar solo la vista "app.blade.php"
        $this->publishes([
            HEXAGONAL_PATH.'/resources/views/components/layout/app.blade.php' => base_path('resources/views/vendor/hexagonal/components/layout/app.blade.php'),
            HEXAGONAL_PATH.'/src/Infrastructure/View/Components/Layout/App.php' => app_path('View/Components/Layout/App.php'),
        ], 'hexagonal-view-layout');


        /*
         * -----------------------
         * --- Configuraciones ---
         * -----------------------
         */

        // hexagonal.php
        $this->publishes([
            HEXAGONAL_PATH.'/config/hexagonal.php' => config_path('hexagonal.php'),
        ], 'hexagonal-config');

        // hexagonal_auth.php
        $this->publishes([
            HEXAGONAL_PATH.'/config/hexagonal_auth.php' => config_path('hexagonal_auth.php'),
        ], 'hexagonal-config-auth');

        // hexagonal_layout.php
        $this->publishes([
            HEXAGONAL_PATH.'/config/hexagonal_layout.php' => config_path('hexagonal_layout.php'),
        ], 'hexagonal-config-layout');

        // hexagonal_links.php
        $this->publishes([
            HEXAGONAL_PATH.'/config/hexagonal_links.php' => config_path('hexagonal_links.php'),
        ], 'hexagonal-config-links');


        /*
         * --------------------
         * --- Traducciones ---
         * --------------------
         */

        $langPath = Version::laravelMin9()
            ? $this->app->langPath('vendor/hexagonal')
            : $this->app->resourcePath('lang/vendor/hexagonal');
        $this->publishes([
            HEXAGONAL_PATH.'/lang' => $langPath,
        ], 'hexagonal-lang');
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
            Version::laravelMin9()
        ) {
            $this->loadMigrationsFrom(HEXAGONAL_PATH.'/database/migrations');
            $this->loadMigrationsFrom(HEXAGONAL_PATH.'/stubs/generate/database/migrations');
        }
    }

    /**
     * Register Package's migration files.
     *
     * @return void
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(HEXAGONAL_PATH.'/lang', 'h');
        $this->loadJsonTranslationsFrom(HEXAGONAL_PATH.'/lang');
    }

    /**
     * Register Package's components files.
     *
     * @return void
     */
    protected function registerComponents(): void
    {
        if (!Version::laravelMin9()) return;

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
        /** @var Router $router */
        $router = $this->app->make(Router::class);
//        /** @var Kernel $kernel */
//        $kernel = $this->app->make(Kernel::class);

        // Registrar/sobreescribir un grupo de middlewares
//        $router->middlewareGroup('newCustomGroup', [\Vendor\Package\Http\Middleware\HexagonalAnyMiddleware::class]);

        // Añadir un middleware a un grupo
//        $router->pushMiddlewareToGroup('web', ShareInertiaData::class);

        // Registrar middlewares solo para rutas específicas
        $router->aliasMiddleware('userCan', UserHasPermission::class);
        $router->aliasMiddleware('userIs', UserHasRole::class);

        // El Middleware AddPreferencesCookies al grupo de rutas web
        if (
            !$this->app->runningInConsole() &&
            !empty(config('app.key')) &&
            Hexagonal::enabledPreferencesCookie()
        ) {
            // Añadir un middleware a un grupo
            $router->pushMiddlewareToGroup('web', \Thehouseofel\Hexagonal\Infrastructure\Http\Middleware\AddPreferencesCookies::class); // $kernel->appendMiddlewareToGroup('web', \Thehouseofel\Hexagonal\Infrastructure\Http\Middleware\AddPreferencesCookies::class);

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

            // Divide ambas cadenas en arrays y elimina los strings vacíos
            $defaultArray = array_filter(explode(' ', $defaultClasses));
            $customArray = array_filter(explode(' ', $customClasses));

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
}
