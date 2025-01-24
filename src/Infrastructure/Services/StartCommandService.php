<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\ServiceProvider;
use Thehouseofel\Hexagonal\Infrastructure\Console\Commands\HexagonalStart;
use Thehouseofel\Hexagonal\Infrastructure\HexagonalServiceProvider;

final class StartCommandService
{
    private $command;
    private $reset;
    private $filesystem;
    private $skipHarmlessMethods;

    public function __construct(HexagonalStart $command, bool $reset)
    {
        $this->command             = $command;
        $this->reset               = $reset;
        $this->filesystem          = $command->filesystem();
        $this->skipHarmlessMethods = false;
    }

    /**
     * Update the "package.json" file.
     *
     * @param string $configurationKey
     * @param array $items
     * @param bool $remove
     * @return void
     */
    private function modifyPackageJsonSection(string $configurationKey, array $items, bool $remove = false)
    {
        $filePath = base_path('package.json');

        if (!file_exists($filePath)) {
            return;
        }

        $packages = json_decode(file_get_contents($filePath), true);

        // Obtenemos la sección que se va a modificar o un array vacío si no existe
        $currentSection = $packages[$configurationKey] ?? [];

        if ($remove) {
            // Eliminamos los elementos especificados
            foreach ($items as $key => $value) {
                unset($currentSection[$key]);
            }
            $packages[$configurationKey] = $currentSection;
        } else {
            // Añadimos los elementos a la sección
            $packages[$configurationKey] = $items + $currentSection;
            ksort($packages[$configurationKey]);
        }

        // Guardamos los cambios en package.json
        file_put_contents(
            $filePath,
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    public static function configure(HexagonalStart $command, bool $reset): self
    {
        if (!Version::laravelIsEqualOrGreaterThan11()) {
            $command->fail('Por ahora este comando solo esta preparado para la version de laravel 11');
        }
        return new self($command, $reset);
    }

    public function restoreFilesModifiedByPackageLaravelTsUtils(): self
    {
        // Restore "resources"
        $this->filesystem->deleteDirectory(resource_path());
        $this->filesystem->ensureDirectoryExists(resource_path());
        $this->filesystem->copyDirectory($this->command->originalStubsPath('resources'), base_path('resources'));

        // Delete ".prettierrc"
        $this->filesystem->delete(base_path('.prettierrc'));

        // Delete "tailwind.config.ts"
        $this->filesystem->delete(base_path('tailwind.config.ts'));
        copy($this->command->originalStubsPath('tailwind.config.js'), base_path('tailwind.config.js'));

        // Delete "tailwind.config.ts"
        $this->filesystem->delete(base_path('tsconfig.json'));

        // Delete "vite.config.ts"
        $this->filesystem->delete(base_path('vite.config.ts'));
        copy($this->command->originalStubsPath('vite.config.js'), base_path('vite.config.js'));

        $this->command->info('Restaurados todos los archivos modificados por el paquete laravel-ts-utils');

        return $this;
    }

    public function publishHexagonalConfig(): self
    {
        // Delete "config/hexagonal.php"
        $this->filesystem->delete(config_path('hexagonal.php'));

        if ($this->reset) return $this;

        // Publish "config/hexagonal.php"
        $this->command->call('vendor:publish', ['--tag' => 'hexagonal-config']);
        $this->command->info('Configuración del paquete publicada: "config/hexagonal.php"');

        return $this;
    }

    public function stubsCopyFile_AppServiceProvider(): self
    {
        $file = 'app/Providers/AppServiceProvider.php';

        $from = ($this->reset) ? $this->command->originalStubsPath($file) : $this->command->stubsPath($file);
        $to = base_path($file);

        copy($from, $to);
        $this->command->info('Archivo "'.$file.'" creado');

        return $this;
    }

    public function stubsCopyFile_DependencyServiceProvider(): self
    {
        $file = 'app/Providers/DependencyServiceProvider.php';

        $from = $this->command->stubsPath($file);
        $to = base_path($file);

        if ($this->reset) {
            $this->filesystem->delete($to);
            $this->command->info('Archivo "'.$file.'" eliminado');
            return $this;
        }

        copy($from, $to);
        $this->command->info('Archivo "'.$file.'" creado');

        return $this;
    }

    public function stubsCopyFolder_Views(): self
    {
        // Views
        $folder = 'resources/views';

        $dir = ($this->reset) ? $this->command->originalStubsPath($folder) : $this->command->stubsPath($folder);
        $dest = base_path($folder);

        $this->filesystem->ensureDirectoryExists($dest);
        $this->filesystem->copyDirectory($dir, $dest);
        $this->command->info('Carpeta "'.$folder.'" creada');

        return $this;
    }

    public function stubsCopyFolder_Src(): self
    {
        // Src
        $folder = 'src';

        $dir = $this->command->stubsPath($folder);
        $dest = base_path($folder);

        if ($this->reset) {
            $this->filesystem->deleteDirectory($dest);
            $this->command->info('Carpeta "'.$folder.'" eliminada');
            return $this;
        }

        $this->filesystem->ensureDirectoryExists($dest);
        $this->filesystem->copyDirectory($dir, $dest);
        $this->command->info('Carpeta "'.$folder.'" creada');

        return $this;
    }

    public function stubsCopyFile_RoutesWeb(): self
    {
        // routes/web.php
        $originalFile = 'routes/web.php';
        $generatedFile = 'routes/'.(Version::phpIsEqualOrGreaterThan74() ? 'web.php' : 'web_php_old.php');

        $from = ($this->reset) ? $this->command->originalStubsPath($originalFile) : $this->command->stubsPath($generatedFile);
        $to = base_path($originalFile);

        copy($from, $to);
        $this->command->info('Archivo "'.$originalFile.'" modificado');

        return $this;
    }

    public function stubsCopyFile_tailwindConfigJs(): self
    {
        // tailwind.config.js
        $file = 'tailwind.config.js';

        $from = ($this->reset) ? $this->command->originalStubsPath($file) : $this->command->stubsPath($file);
        $to = base_path($file);

        copy($from, $to);
        $this->command->info('Archivo "'.$file.'" modificado');

        return $this;
    }

    public function createEnvFiles(): self
    {
        // Crear archivos ".env" y ".env.local"

        $file = '.env.local';
        $from = $this->command->stubsPath($file);
        $to_envLocal = base_path($file);
        $to_env = base_path('.env');

        if ($this->reset) {
            $this->filesystem->delete($to_envLocal);
            $this->filesystem->delete($to_env);
            $this->command->info('Archivos ".env" eliminados');
            return $this;
        }

        copy($from, $to_envLocal);
        copy($from, $to_env);

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
        $folder = 'app/Http';
        $dest = base_path($folder);

        if ($this->reset) {
            $dir = $this->command->originalStubsPath($folder);
            $this->filesystem->ensureDirectoryExists($dest);
            $this->filesystem->copyDirectory($dir, $dest);
            $this->command->info('Carpeta "'.$folder.'" creada');
            return $this;
        }

        $this->filesystem->deleteDirectory($dest);
        $this->command->info('Directorio "'.$folder.'" eliminado');

        return $this;
    }

    public function deleteDirectory_Models(): self
    {
        // Delete directory "app/Models"
        /*$folder = 'app/Models';
        $dir = base_path($folder);

        $this->filesystem->deleteDirectory($dir);
        $this->command->info('Directorio "'.$folder.'" eliminado');*/

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
        // bootstrap/providers.php

        if (!Version::laravelIsEqualOrGreaterThan11()) {
            return $this;
        }

        if ($this->reset) {
            HexagonalServiceProvider::removeProviderFromBootstrapFile('App\Providers\DependencyServiceProvider');
        } else {
            ServiceProvider::addProviderToBootstrapFile('App\Providers\DependencyServiceProvider');
        }

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
        $replacement = ($this->reset)
            ?  <<<'EOD'
->withExceptions(function (Exceptions $exceptions) {
        //
    })
EOD
            : <<<'EOD'
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

        // Leer el contenido del archivo
        $filePath = database_path('seeders/DatabaseSeeder.php');
        $fileContent = file_get_contents($filePath);

        // Expresión regular para encontrar el contenido dentro del método run()
        $pattern = '/public function run\(\): void\s*\{([\s\S]*?)\}/';

        $modifiedContent = preg_replace_callback($pattern, function ($matches) {
            $lines = explode("\n", $matches[1]); // Separar en líneas

            $processedLines = array_map(function ($line) {
                $trimmedLine = trim($line);

                if ($this->reset) {
                    // Descomentar líneas que tengan "//0"
                    if (str_starts_with($trimmedLine, '//0')) {
                        return substr($line, strpos($line, '//0') + 4); // Quitar "//0 " del inicio
                    }
                } else {
                    // Comentar líneas no comentadas
                    if ($trimmedLine !== '' && !str_starts_with($trimmedLine, '//')) {
                        return '//0 ' . $line;
                    }
                }

                return $line; // Dejar la línea intacta si no se aplica la acción
            }, $lines);

            return "public function run(): void\n    {" . implode("\n", $processedLines) . "}";
        }, $fileContent);

        // Sobrescribir el archivo con el contenido modificado
        file_put_contents($filePath, $modifiedContent);

        return $this;
    }

    public function modifyFile_JsBootstrap_toAddImportFlowbite(): self
    {
        // Import "flowbite" in resources/js/bootstrap.js
        $filePath = base_path('resources/js/bootstrap.js');

        if (!file_exists($filePath)) {
            return $this;
        }

        $fileContents = file_get_contents($filePath);

        $importLine = "import 'flowbite';";

        if ($this->reset) {
            // Remove the import line from the file
            $fileContents = str_replace($importLine . PHP_EOL, '', $fileContents);
        } else {
            if (str_contains($fileContents, $importLine)) {
                return $this;
            }
            // Add the import line to the beginning of the file
            $fileContents = $importLine . PHP_EOL . $fileContents;
        }

        file_put_contents($filePath, $fileContents);

        $this->command->info('Archivo "resources/js/bootstrap.js" modificado');

        return $this;
    }

    public function modifyFile_Gitignore_toDeleteLockFileLines(): self
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

    public function modifyFile_PackageJson_toAddNpmDevDependencies(): self
    {
        // Install NPM packages...
        $this->modifyPackageJsonSection('devDependencies', [
            '@types/node'                   => '^22.5.5',
            'flowbite'                      => '^2.5.1',
            'prettier'                      => '^3.3.3',
            'prettier-plugin-blade'         => '^2.1.19',
            'prettier-plugin-tailwindcss'   => '^0.6.8',
            'typescript'                    => '^5.6.2',
        ], $this->reset);

        $this->command->info('Archivo package.json actualizado (devDependencies)');

        return $this;
    }

    public function modifyFile_PackageJson_toAddScriptTsBuild(): self
    {
        // Add script "ts-build" in "package.json"
        $this->modifyPackageJsonSection('scripts', [
            'ts-build' => 'tsc && vite build',
        ], $this->reset);

        $this->command->info('Archivo package.json actualizado (script "ts-build")');

        return $this;
    }

    public function modifyFile_ComposerJson_toAddSrcNamespace(): self
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

    public function execute_ComposerRequire_toInstallComposerDependencies(): self
    {
        // Install "tightenco/ziggy"

        $content = file_get_contents(base_path('composer.json'));
        if (str_contains($content, 'tightenco/ziggy')) {
            return $this;
        }

        $this->command->executeRequireComposerPackages(
            $this->command->option('composer'),
            ['tightenco/ziggy']
        );
        $this->command->info('Dependencias de composer instaladas');

        return $this;
    }

    public function execute_ComposerDumpAutoload(): self
    {
        // Execute the "composer dump-autoload" command

        if ($this->skipHarmlessMethods) {
            return $this;
        }

        $run = Process::run('composer dump-autoload');
        if ($run->failed()) {
            $this->command->warn('The command "composer dump-autoload" has failed');
        } else {
            $this->command->info('Command "composer dump-autoload" successfully.');
        }

        return $this;
    }

    public function execute_NpminstallAndNpmRunBuild(): self
    {
        // Install and build Node dependencies.

        if ($this->skipHarmlessMethods) {
            return $this;
        }

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