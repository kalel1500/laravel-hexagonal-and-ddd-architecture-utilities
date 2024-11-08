<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class HexagonalStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hexagonal:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create starter files for hexagonal architecture';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * --- Creación de archivos ---
         */

        // DependencyServiceProvider
        copy(HEXAGONAL_PATH.'/stubs/app/Providers/DependencyServiceProvider.php', app_path('Providers/DependencyServiceProvider.php'));
        $this->info('Archivo "app/Providers/DependencyServiceProvider.php" creado');

        // resources
        $this->filesystem->ensureDirectoryExists(resource_path('views/pages'));
        $this->filesystem->copyDirectory(HEXAGONAL_PATH.'/stubs/resources/views/pages', resource_path('views/pages'));
        $this->info('Carpeta "resources/views/pages" creada');

        // Src
        $this->filesystem->ensureDirectoryExists(base_path('src'));
        $this->filesystem->copyDirectory(HEXAGONAL_PATH.'/stubs/src', base_path('src'));
        $this->info('Carpeta "src" creada');

        // .env.local
        copy(HEXAGONAL_PATH.'/stubs/.env.local', base_path('.env.local'));
        $this->info('Archivo ".env.local" creado');


        /**
         * --- Modificación de archivos ---
         */

        // /bootstrap/providers.php
        ServiceProvider::addProviderToBootstrapFile('App\Providers\DependencyServiceProvider');
        $this->info('Archivo "/bootstrap/providers.php" modificado');

        // /bootstrap/app.php
        $this->installException([
            '$callback = \Thehouseofel\Hexagonal\Infrastructure\Exceptions\ExceptionHandler::getUsingCallback();',
            '$callback($exceptions);',
        ]);
        $this->info('Archivo "/bootstrap/app.php" modificado');
    }

    /**
     * Install the given exception names into the application.
     *
     * @param  array|string  $names
     * @return void
     */
    protected function installException($names)
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $names = collect(Arr::wrap($names))
            ->filter(function ($name) use ($bootstrapApp) { return ! Str::contains($bootstrapApp, $name); })
            ->whenNotEmpty(function ($names) use ($bootstrapApp) {
                $names = $names->implode(PHP_EOL.'        ');

                // Paso 2: Convertir todos los saltos de línea a "\n"
//                $bootstrapApp = str_replace(["\r\n", "\n"], PHP_EOL, $bootstrapApp);

                $bootstrapApp = str_replace(
                    '->withExceptions(function (Exceptions $exceptions) {'.PHP_EOL."        //",
                    '->withExceptions(function (Exceptions $exceptions) {'.PHP_EOL."        $names",
                    $bootstrapApp
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }
}
