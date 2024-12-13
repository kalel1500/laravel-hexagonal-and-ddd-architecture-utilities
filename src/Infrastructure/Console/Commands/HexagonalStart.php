<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\InteractsWithComposerPackages;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class HexagonalStart extends Command
{
    use InteractsWithComposerPackages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hexagonal:start
                    {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create starter files for hexagonal architecture';

    protected $filesystem;
    protected $stubsPath;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->stubsPath = HEXAGONAL_PATH.'/stubs';
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * --- Creación de archivos ---
         */

        // Publish "config/hexagonal.php"
        $this->call('vendor:publish', ['--tag' => 'hexagonal-config']);
        $this->info('Configuración del paquete publicada: "config/hexagonal.php"');

        // DependencyServiceProvider
        copy($this->stubsPath.'/app/Providers/DependencyServiceProvider.php', app_path('Providers/DependencyServiceProvider.php'));
        $this->info('Archivo "app/Providers/DependencyServiceProvider.php" creado');

        // Views
        $this->filesystem->ensureDirectoryExists(resource_path('views'));
        $this->filesystem->copyDirectory($this->stubsPath.'/resources/views', resource_path('views'));
        $this->info('Carpeta "resources/views" creada');

        // Src
        $this->filesystem->ensureDirectoryExists(base_path('src'));
        $this->filesystem->copyDirectory($this->stubsPath.'/src', base_path('src'));
        $this->info('Carpeta "src" creada');

        // .env.local
        $this->createEnvFiles();
        $this->info('Archivos ".env" creados');


        /**
         * --- Eliminar archivos ---
         */

        // Delete directory "app/Http"
        $this->filesystem->deleteDirectory(app_path('Http'));
        $this->info('Directorio "app/Http" eliminado');

        // Delete directory "app/Models"
//        $this->filesystem->deleteDirectory(app_path('Models'));
//        $this->info('Directorio "app/Models" eliminado');

        // Delete file "CHANGELOG.md"
        $this->filesystem->delete(base_path('CHANGELOG.md'));
        $this->info('Archivo "CHANGELOG.md" eliminado');


        /**
         * --- Modificación de archivos ---
         */

        // app/Providers/AppServiceProvider.php
        $this->addCommentIgnoreMigrationsInAppServiceProvider();

        // bootstrap/providers.php
        ServiceProvider::addProviderToBootstrapFile('App\Providers\DependencyServiceProvider');
        $this->info('Archivo "bootstrap/providers.php" modificado');

        // bootstrap/app.php
        $this->installException([
            '$callback = \Thehouseofel\Hexagonal\Infrastructure\Exceptions\ExceptionHandler::getUsingCallback();',
            '$callback($exceptions);',
        ]);
        $this->info('Archivo "bootstrap/app.php" modificado');

        // routes/web.php
        copy($this->stubsPath.'/routes/web.php', base_path('routes/web.php'));
        $this->info('Archivo "routes/web.php" modificado');

        // Comment User factory in "database/seeders/DatabaseSeeder.php"
        $this->filesystem->replaceInFile(['User::factory()->create([', ']);'], ['/*User::factory()->create([', ']);*/'], database_path('seeders/DatabaseSeeder.php'));
        $this->info('Archivo "database/seeders/DatabaseSeeder.php" modificado');

        // Import "flowbite" in resources/js/bootstrap.js
        $this->filesystem->replaceInFile("import axios from 'axios';", "import axios from 'axios';".PHP_EOL."import 'flowbite';", resource_path('js/bootstrap.js'));
        $this->info('Archivo "resources/js/bootstrap.js" modificado');

        // tailwind.config.js
        copy($this->stubsPath.'/tailwind.config.js', base_path('tailwind.config.js'));
        $this->info('Archivo "tailwind.config.js" modificado');

        // Borrar los ".lock" del ".gitignore"
        $this->deleteLockFilesFromGitignore();
        $this->info('Archivos ".lock" eliminados del ".gitignore"');

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
        $this->info('Dependencias de NPM instaladas');

        // Add script "ts-build" in "package.json"
        $this->updatePackageJsonSection('scripts', function ($packages) { return ['ts-build' => 'tsc && vite build',] + $packages; });
        $this->info('Script "ts-build" añadido al "package.json"');

        // Install "tightenco/ziggy"
        $this->requireComposerPackages($this->option('composer'), ['tightenco/ziggy']);
        $this->info('Dependencias instaladas');

        // Add the "Src" namespace into "composer.json"
        $this->addNamespacesInComposerJson(["Src\\" => "src/",]);
        $this->info('Namespace "Src" añadido al "composer.json"');

        // Run commands
        $this->executeComposerDumpAutoload();
        $this->installNodeDependencies();
    }

    /**
     * Custom method
     *
     * @return void
     */
    protected function createEnvFiles()
    {
        // Crear archivo ".env.local"
        copy($this->stubsPath.'/.env.local', base_path('.env.local'));

        // Crear archivo ".env"
        copy($this->stubsPath.'/.env.local', base_path('.env'));

        // Borrar manualmente el valor de config('app.key') para que se regenere correctamente
        config(['app.key' => '']);

        // Regenerar Key
        $this->call('key:generate');
    }

    /**
     * Custom method
     *
     * @return void
     */
    protected function addCommentIgnoreMigrationsInAppServiceProvider()
    {
        $filePath = app_path('Providers/AppServiceProvider.php');

        // Detecta el tipo de salto de línea en el archivo
        $lineEnding = strpos(file_get_contents($filePath), "\r\n") !== false ? "\r\n" : "\n";

        $this->filesystem->replaceInFile(
            "public function register(): void" . $lineEnding . "    {" . $lineEnding . "        //",
            "public function register(): void" . $lineEnding . "    {" . $lineEnding . "        // \Thehouseofel\Hexagonal\Infrastructure\Services\Hexagonal::configure()->enablePreferencesCookie();",
            app_path('Providers/AppServiceProvider.php')
        );
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

    /**
     * Custom method
     *
     * @return void
     */
    protected function deleteLockFilesFromGitignore()
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
    }

    /**
     * Update the "autoload.psr-4" section in "composer.json" file with additional namespaces.
     *
     * @param array $additionalNamespaces Array of namespaces to add, e.g., ["Src\\" => "src/"]
     * @return void
     */
    protected function addNamespacesInComposerJson(array $additionalNamespaces)
    {
        $filePath = base_path('composer.json');

        if (!file_exists($filePath)) {
            return;
        }

        $composerConfig = json_decode(file_get_contents($filePath), true);

        // Asegurarse de que las claves necesarias existan
        if (!isset($composerConfig['autoload']['psr-4'])) {
            return;
        }

        $psr4 = $composerConfig['autoload']['psr-4'];

        // Insertar cada nuevo namespace después de "App\\"
        $updatedPsr4 = [];
        foreach ($psr4 as $namespace => $path) {
            $updatedPsr4[$namespace] = $path;

            // Insertar los nuevos namespaces después de "App\\"
            if ($namespace === 'App\\') {
                foreach ($additionalNamespaces as $newNamespace => $newPath) {
                    $updatedPsr4[$newNamespace] = $newPath;
                }
            }
        }

        // Actualizar el valor de psr-4 en la configuración de composer
        $composerConfig['autoload']['psr-4'] = $updatedPsr4;

        // Convertir el arreglo a JSON y formatear con JSON_PRETTY_PRINT
        $jsonContent = json_encode($composerConfig, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        // Usa una expresión regular para encontrar la key "keywords" y ponerla en una línea
        $jsonContent = preg_replace_callback(
            '/"keywords": \[\s+([^]]+?)\s+]/s',
            function ($matches) {
                // Limpia el contenido de "keywords" y colócalo en una línea
                $keywords = preg_replace('/\s+/', '', $matches[1]);  // Elimina espacios y saltos de línea
                $keywords = str_replace('","', '", "', $keywords);   // Añade un espacio después de cada coma
                return '"keywords": [' . $keywords . ']';
            },
            $jsonContent
        );

        // Guardar el archivo actualizado
        file_put_contents($filePath, $jsonContent . PHP_EOL);
    }

    /**
     * Execute the "composer dump-autoload" command
     *
     * @return void
     */
    protected function executeComposerDumpAutoload()
    {
        $run = Process::run('composer dump-autoload');
        if ($run->failed()) {
            $this->warn('The command "composer dump-autoload" has failed');
        } else {
            $this->info('Command "composer dump-autoload" successfully.');
        }
    }

    /**
     * Install and build Node dependencies.
     *
     * @return void
     */
    protected function installNodeDependencies()
    {
        $this->info('Installing and building Node dependencies.');

        $commands = [
            'npm install',
            'npm run build',
        ];

        $command = Process::command(implode(' && ', $commands))->path(base_path());

        if (! windows_os()) {
            $command->tty();
        }

        if ($command->run()->failed()) {
            $this->warn("Node dependency installation failed. Please run the following commands manually: \n\n".implode(' && ', $commands));
        } else {
            $this->info('Node dependencies installed successfully.');
        }
    }

}
