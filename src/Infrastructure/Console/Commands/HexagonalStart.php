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

        // Borrar los ".lock" del ".gitignore"
        $this->clearGitignore();

        // Install NPM packages...
        $this->updatePackageJsonSection('devDependencies', function ($packages) {
            return [
                '@types/node'                   => '^22.5.5',
                'flowbite'                      => '^2.5.1',
                'prettier'                      => '^3.3.3',
                'prettier-plugin-blade'         => '^2.1.19',
                'prettier-plugin-tailwindcss'   => '^0.6.8',
                'typescript'                    => '^5.6.2',
            ] + $packages;
        });

        // Add script "ts-build" in "package.json"
        $this->updatePackageJsonSection('scripts', function ($packages) {
            return [
                    'ts-build'                   => 'tsc && vite build',
                ] + $packages;
        });
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

    protected function clearGitignore()
    {
        // Ruta del archivo .gitignore
        $gitignorePath    = base_path('.gitignore');
        $gitignoreContent = file($gitignorePath, FILE_IGNORE_NEW_LINES); // Leer el archivo como un array de líneas

        // Definir las líneas que queremos eliminar
        $linesToRemove = ['composer.lock', 'package-lock.json'];

        // Filtrar el contenido para eliminar solo las líneas especificadas
        $gitignoreContent = array_filter($gitignoreContent, function ($line) use ($linesToRemove) {
            return !in_array($line, $linesToRemove, true); // Mantener líneas que no están en $linesToRemove
        });

        // Eliminar cualquier línea vacía adicional al final del contenido
        while (end($gitignoreContent) === '') {
            array_pop($gitignoreContent);
        }

        // Escribir el contenido actualizado en el archivo con una sola línea vacía al final
        file_put_contents($gitignorePath, implode(PHP_EOL, $gitignoreContent) . PHP_EOL);

        // Informar al usuario
        $this->info('Archivos ".lock" eliminados del ".gitignore"');
    }

    /**
     * Update the "package.json" file.
     *
     * @param string $configurationKey
     * @param callable $callback
     * @return void
     */
    protected function updatePackageJsonSection(string $configurationKey, callable $callback)
    {
        $filePath = base_path('package.json');

        if (!file_exists($filePath)) {
            return;
        }

        $packages = json_decode(file_get_contents($filePath), true);

        $packages[$configurationKey] = $callback(
            $packages[$configurationKey] ?? [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            $filePath,
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );

        $this->info('Archivo "package.json" modificado');
    }
}
