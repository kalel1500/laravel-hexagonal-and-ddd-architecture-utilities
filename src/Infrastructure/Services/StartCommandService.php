<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\ServiceProvider;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\HexagonalStart;

final class StartCommandService
{
    private $command;
    private $filesystem;
    private $stubsPath;

    public function __construct(HexagonalStart $command)
    {
        $this->command    = $command;
        $this->filesystem = $command->filesystem();
        $this->stubsPath  = $command->stubsPath();
    }

    /**
     * Update the "package.json" file.
     *
     * @param string $configurationKey
     * @param callable $callback
     * @return void
     */
    private function updatePackageJsonSection(string $configurationKey, callable $callback)
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

    public static function configure(HexagonalStart $command): self
    {
        if (!Version::laravelIsEqualOrGreaterThan11()) {
            $command->fail('Por ahora este comando solo esta preparado para la version de laravel 11');
        }
        return new self($command);
    }

    public function publishHexagonalConfig(): self
    {
        // Delete "config/hexagonal.php"
        $this->filesystem->delete(config_path('hexagonal.php'));

        // Publish "config/hexagonal.php"
        $this->command->call('vendor:publish', ['--tag' => 'hexagonal-config']);
        $this->command->info('Configuración del paquete publicada: "config/hexagonal.php"');

        return $this;
    }

    public function stubsCopyFile_AppServiceProvider(): self
    {
        // DependencyServiceProvider
        copy($this->stubsPath . '/app/Providers/AppServiceProvider.php', app_path('Providers/AppServiceProvider.php'));
        $this->command->info('Archivo "app/Providers/AppServiceProvider.php" creado');

        return $this;
    }

    public function stubsCopyFile_DependencyServiceProvider(): self
    {
        // DependencyServiceProvider
        copy($this->stubsPath . '/app/Providers/DependencyServiceProvider.php', app_path('Providers/DependencyServiceProvider.php'));
        $this->command->info('Archivo "app/Providers/DependencyServiceProvider.php" creado');

        return $this;
    }

    public function stubsCopyFolder_Views(): self
    {
        // Views
        $this->filesystem->ensureDirectoryExists(resource_path('views'));
        $this->filesystem->copyDirectory($this->stubsPath . '/resources/views', resource_path('views'));
        $this->command->info('Carpeta "resources/views" creada');

        return $this;
    }

    public function stubsCopyFolder_Src(): self
    {
        // Src
        $this->filesystem->ensureDirectoryExists(base_path('src'));
        $this->filesystem->copyDirectory($this->stubsPath.'/src', base_path('src'));
        $this->command->info('Carpeta "src" creada');

        return $this;
    }

    public function stubsCopyFile_RoutesWeb(): self
    {
        // routes/web.php
        $webFile = Version::phpIsEqualOrGreaterThan74() ? 'web.php' : 'web_php_old.php';
        copy($this->stubsPath.'/routes/'.$webFile, base_path('routes/web.php'));
        $this->command->info('Archivo "routes/web.php" modificado');

        return $this;
    }

    public function stubsCopyFile_tailwindConfigJs(): self
    {
        // tailwind.config.js
        copy($this->stubsPath.'/tailwind.config.js', base_path('tailwind.config.js'));
        $this->command->info('Archivo "tailwind.config.js" modificado');

        return $this;
    }

    public function createEnvFiles(): self
    {
        // Crear archivo ".env.local"
        copy($this->stubsPath.'/.env.local', base_path('.env.local'));

        // Crear archivo ".env"
        copy($this->stubsPath.'/.env.local', base_path('.env'));

        // Borrar manualmente el valor de config('app.key') para que se regenere correctamente
        config(['app.key' => '']);

        // Regenerar Key
        $this->command->call('key:generate');

        $this->command->info('Archivos ".env" creados');

        return $this;
    }

    public function deleteDirectory_Http(): self
    {
        // Delete directory "app/Http"
        $this->filesystem->deleteDirectory(app_path('Http'));
        $this->command->info('Directorio "app/Http" eliminado');

        return $this;
    }

    public function deleteDirectory_Models(): self
    {
        // Delete directory "app/Models"
//        $this->filesystem->deleteDirectory(app_path('Models'));
//        $this->command->info('Directorio "app/Models" eliminado');

        return $this;
    }

    public function deleteFile_Changelog(): self
    {
        // Delete file "CHANGELOG.md"
        $this->filesystem->delete(base_path('CHANGELOG.md'));
        $this->command->info('Archivo "CHANGELOG.md" eliminado');

        return $this;
    }

    public function modifyFile_BootstrapProviders_toAddDependencyServiceProvider(): self
    {
        if (!Version::laravelIsEqualOrGreaterThan11()) {
            return $this;
        }

        // bootstrap/providers.php
        ServiceProvider::addProviderToBootstrapFile('App\Providers\DependencyServiceProvider');
        $this->command->info('Archivo "bootstrap/providers.php" modificado');

        return $this;
    }

    public function modifyFile_BootstrapApp_toAddExceptionHandler(): self
    {
        if (!Version::laravelIsEqualOrGreaterThan11()) {
            return $this;
        }

        // Ruta del archivo a modificar
        $filePath = base_path('bootstrap/app.php');

        // Leer el contenido del archivo
        $content = File::get($filePath);

        // Usar una expresión regular para encontrar y reemplazar el bloque `withExceptions`
        $pattern = '/->withExceptions\(function \(Exceptions \$exceptions\) \{(.*?)}\)/s';

        // Reemplazar el contenido del bloque con las nuevas líneas
        $replacement = <<<'EOD'
->withExceptions(function (Exceptions $exceptions) {
        $callback = \Thehouseofel\Hexagonal\Infrastructure\Exceptions\ExceptionHandler::getUsingCallback();
        $callback($exceptions);
    })
EOD;

        $newContent = preg_replace($pattern, $replacement, $content);

        // Guardar el archivo con el contenido actualizado
        File::put($filePath, $newContent);

        $this->command->info('Archivo "bootstrap/app.php" modificado');

        return $this;
    }

    public function modifyFile_DatabaseSeeder_toCommentUserFactory(): self
    {
        // Comment User factory in "database/seeders/DatabaseSeeder.php"

        $filePath = database_path('seeders/DatabaseSeeder.php');
        $content = $this->filesystem->get($filePath);

        // Verificar si el bloque ya está comentado
        if (!str_contains($content, '/*User::factory()->create([')) {
            $this->filesystem->replaceInFile(
                ['User::factory()->create([', ']);'],
                ['/*User::factory()->create([', ']);*/'],
                $filePath
            );
            $this->command->info('Archivo "database/seeders/DatabaseSeeder.php" modificado');
        }

        return $this;
    }

    public function modifyFile_JsBootstrap_toAddImportFlowbite(): self
    {
        // Import "flowbite" in resources/js/bootstrap.js
        $this->filesystem->replaceInFile(
            "import axios from 'axios';",
            "import axios from 'axios';".PHP_EOL."import 'flowbite';",
            resource_path('js/bootstrap.js')
        );
        $this->command->info('Archivo "resources/js/bootstrap.js" modificado');

        return $this;
    }

    public function deleteLockFilesFromGitignore(): self
    {
        // Borrar los ".lock" del ".gitignore"

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

        $this->command->info('Archivos ".lock" eliminados del ".gitignore"');

        return $this;
    }

    public function addNpmDevDependenciesInPackageJsonFile(): self
    {
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
        $this->command->info('Dependencias de NPM instaladas');

        return $this;
    }

    public function addScriptTsBuildInPackageJsonFile(): self
    {
        // Add script "ts-build" in "package.json"
        $this->updatePackageJsonSection('scripts', function ($packages) {
            return [
                'ts-build' => 'tsc && vite build',
                ] + $packages;
        });
        $this->command->info('Script "ts-build" añadido al "package.json"');

        return $this;
    }

    public function installComposerDependencies(): self
    {
        // Install "tightenco/ziggy"
        $this->command->requireComposerPackages(
            $this->command->option('composer'),
            ['tightenco/ziggy']
        );
        $this->command->info('Dependencias de composer instaladas');

        return $this;
    }

    public function addNamespacesInComposerJson(): self
    {
        // Update the "autoload.psr-4" section in "composer.json" file with additional namespaces.
        // Add the "Src" namespace into "composer.json"

        $additionalNamespaces = ["Src\\" => "src/"];

        $filePath = base_path('composer.json');

        if (!file_exists($filePath)) {
            return $this;
        }

        $composerConfig = json_decode(file_get_contents($filePath), true);

        // Asegurarse de que las claves necesarias existan
        if (!isset($composerConfig['autoload']['psr-4'])) {
            return $this;
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


        $this->command->info('Namespace "Src" añadido al "composer.json"');

        return $this;
    }

    public function executeComposerDumpAutoload(): self
    {
        // Execute the "composer dump-autoload" command
        $run = Process::run('composer dump-autoload');
        if ($run->failed()) {
            $this->command->warn('The command "composer dump-autoload" has failed');
        } else {
            $this->command->info('Command "composer dump-autoload" successfully.');
        }

        return $this;
    }

    public function installNodeDependencies(): self
    {
        // Install and build Node dependencies.

        $this->command->info('Installing and building Node dependencies.');

        $commands = [
            'npm install',
            'npm run build',
        ];

        $command = Process::command(implode(' && ', $commands))->path(base_path());

        if (! windows_os()) {
            $command->tty();
        }

        if ($command->run()->failed()) {
            $this->command->warn("Node dependency installation failed. Please run the following commands manually: \n\n".implode(' && ', $commands));
        } else {
            $this->command->info('Node dependencies installed successfully.');
        }


        return $this;
    }

}