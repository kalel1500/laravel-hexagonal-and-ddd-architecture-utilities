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
    private $simple;
    private $steps;
    private $filesystem;
    private $packageInDevelop;

    public function __construct(HexagonalStart $command, bool $reset, bool $simple, int $steps)
    {
        $this->command          = $command;
        $this->reset            = $reset;
        $this->simple           = $simple;
        $this->steps            = $steps;
        $this->filesystem       = $command->filesystem();
        $this->packageInDevelop = config('hexagonal.package_in_develop');
    }

    private function line($number, $message)
    {
        $this->command->line("  - <fg=yellow>$number/$this->steps</> $message");
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

            // Si la sección queda vacía, la eliminamos completamente
            if (empty($currentSection)) {
                unset($packages[$configurationKey]);
            } else {
                $packages[$configurationKey] = $currentSection;
            }
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

    private function execute_Process($number, $command, $startMessage, $successMessage, $failureMessage)
    {
        // Imprimir mensaje de inicio del proceso
        $this->line($number, $startMessage);

        // Ejecutamos el proceso
        $run = Process::run($command);

        // Verificamos si el proceso falló
        if ($run->failed()) {
            $failureMessageEnd = ' Please run the following command manually: "' . implode(' ', $command) . '"';
            $this->command->warn($failureMessage.$failureMessageEnd);
            $this->command->error($run->errorOutput());
        } else {
            // Imprimimos el mensaje de éxito
            $this->line($number, $successMessage);
        }
    }


    public static function configure(HexagonalStart $command, bool $reset, bool $simple, int $steps): self
    {
        if (!Version::laravelIsEqualOrGreaterThan11()) {
            $command->fail('Por ahora este comando solo esta preparado para la version de laravel 11');
        }
        return new self($command, $reset, $simple, $steps);
    }

    public function restoreFilesModifiedByPackageLaravelTsUtils($number): self
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

        $this->line($number,'Restaurados todos los archivos modificados por el paquete laravel-ts-utils');

        return $this;
    }

    public function publishHexagonalConfig($number): self
    {
        // Delete "config/hexagonal.php"
        $this->filesystem->delete(config_path('hexagonal.php'));

        if ($this->reset) return $this;

        if ($this->packageInDevelop) return $this;

        // Publish "config/hexagonal.php"
        $this->command->call('vendor:publish', ['--tag' => 'hexagonal-config']);
        $this->line($number,'Configuración del paquete publicada: "config/hexagonal.php"');

        return $this;
    }

    public function stubsCopyFile_AppServiceProvider($number): self
    {
        if ($this->packageInDevelop && !$this->reset) return $this;

        $file = 'app/Providers/AppServiceProvider.php';

        $from = ($this->reset) ? $this->command->originalStubsPath($file) : $this->command->stubsPath($file);
        $to = base_path($file);

        copy($from, $to);
        $this->line($number,'Archivo "'.$file.'" creado');

        return $this;
    }

    public function stubsCopyFile_DependencyServiceProvider($number): self
    {
        $file = 'app/Providers/DependencyServiceProvider.php';

        $from = $this->command->stubsPath($file);
        $to = base_path($file);

        if ($this->reset) {
            $this->filesystem->delete($to);
            $this->line($number,'Archivo "'.$file.'" eliminado');
            return $this;
        }

        copy($from, $to);
        $this->line($number,'Archivo "'.$file.'" creado');

        return $this;
    }

    public function stubsCopyFolder_Views($number): self
    {
        // Views
        $folder = 'resources/views';

        $dir = ($this->reset) ? $this->command->originalStubsPath($folder) : $this->command->stubsPath($folder);
        $dest = base_path($folder);

        $this->filesystem->ensureDirectoryExists($dest);
        $this->filesystem->copyDirectory($dir, $dest);
        $this->line($number,'Carpeta "'.$folder.'" creada');

        return $this;
    }

    public function stubsCopyFolder_Src($number): self
    {
        // Src
        $folder = 'src';

        $dir = $this->command->stubsPath($folder);
        $dest = base_path($folder);

        if ($this->reset) {
            $this->filesystem->deleteDirectory($dest);
            $this->line($number,'Carpeta "'.$folder.'" eliminada');
            return $this;
        }

        $this->filesystem->ensureDirectoryExists($dest);
        $this->filesystem->copyDirectory($dir, $dest);
        $this->line($number,'Carpeta "'.$folder.'" creada');

        return $this;
    }

    public function stubsCopyFile_RoutesWeb($number): self
    {
        // routes/web.php
        $originalFile = 'routes/web.php';
        $generatedFile = 'routes/'.(Version::phpIsEqualOrGreaterThan74() ? 'web.php' : 'web_php_old.php');

        $from = ($this->reset) ? $this->command->originalStubsPath($originalFile) : $this->command->stubsPath($generatedFile);
        $to = base_path($originalFile);

        copy($from, $to);
        $this->line($number,'Archivo "'.$originalFile.'" modificado');

        return $this;
    }

    public function stubsCopyFile_tailwindConfigJs($number): self
    {
        // tailwind.config.js
        $file = 'tailwind.config.js';

        $from = ($this->reset) ? $this->command->originalStubsPath($file) : $this->command->stubsPath($file);
        $to = base_path($file);

        copy($from, $to);
        $this->line($number,'Archivo "'.$file.'" modificado');

        return $this;
    }

    public function createEnvFiles($number): self
    {
        // Crear archivos ".env" y ".env.local"

        $file = '.env.local';
        $from = $this->command->stubsPath($file);
        $to_envLocal = base_path($file);
        $to_env = base_path('.env');

        if ($this->reset) {
            $this->filesystem->delete($to_envLocal);
            $this->filesystem->delete($to_env);
            $this->line($number,'Archivos ".env" eliminados');
            return $this;
        }

        copy($from, $to_envLocal);
        copy($from, $to_env);

        // Borrar manualmente el valor de config('app.key') para que se regenere correctamente
        config(['app.key' => '']);

        // Regenerar Key
        $this->command->call('key:generate');

        $this->line($number,'Archivos ".env" creados');

        return $this;
    }

    public function deleteDirectory_Http($number): self
    {
        // Delete directory "app/Http"
        $folder = 'app/Http';
        $dest = base_path($folder);

        if ($this->reset) {
            $dir = $this->command->originalStubsPath($folder);
            $this->filesystem->ensureDirectoryExists($dest);
            $this->filesystem->copyDirectory($dir, $dest);
            $this->line($number,'Carpeta "'.$folder.'" creada');
            return $this;
        }

        $this->filesystem->deleteDirectory($dest);
        $this->line($number,'Directorio "'.$folder.'" eliminado');

        return $this;
    }

    /*public function deleteDirectory_Models($number): self
    {
        // Delete directory "app/Models"
        $folder = 'app/Models';
        $dir = base_path($folder);

        $this->filesystem->deleteDirectory($dir);
        $this->line($number,'Directorio "'.$folder.'" eliminado');

        return $this;
    }*/

    public function deleteFile_Changelog($number): self
    {
        // Delete file "CHANGELOG.md"
        $this->filesystem->delete(base_path('CHANGELOG.md'));
        $this->line($number,'Archivo "CHANGELOG.md" eliminado');

        return $this;
    }

    public function modifyFile_BootstrapProviders_toAddDependencyServiceProvider($number): self
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

        $this->line($number,'Archivo "bootstrap/providers.php" modificado');

        return $this;
    }

    public function modifyFile_BootstrapApp_toAddExceptionHandler($number): self
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

        $this->line($number,'Archivo "bootstrap/app.php" modificado');

        return $this;
    }

    public function modifyFile_DatabaseSeeder_toCommentUserFactory($number): self
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

    public function modifyFile_JsBootstrap_toAddImportFlowbite($number): self
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

        $this->line($number,'Archivo "resources/js/bootstrap.js" modificado');

        return $this;
    }

    public function modifyFile_Gitignore_toDeleteLockFileLines($number): self
    {
        // Borrar los ".lock" del ".gitignore"

        if ($this->packageInDevelop) return $this;

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

        $this->line($number,'Archivos ".lock" eliminados del ".gitignore"');

        return $this;
    }

    public function modifyFile_PackageJson_toAddNpmDevDependencies($number): self
    {
        // Install NPM packages...
        $this->modifyPackageJsonSection('devDependencies', [
            '@types/node'                   => '^22.10.10',
            'flowbite'                      => '^2.5.2',
            'prettier'                      => '^3.4.2',
            'prettier-plugin-blade'         => '^2.1.19',
            'prettier-plugin-tailwindcss'   => '^0.6.11',
            'typescript'                    => '^5.7.3',
        ], $this->reset);

        $this->line($number,'Archivo package.json actualizado (devDependencies)');

        return $this;
    }

    public function modifyFile_PackageJson_toAddNpmDependencies($number): self
    {
        $this->modifyPackageJsonSection('dependencies', [
            '@kalel1500/laravel-ts-utils'   => '^0.4.0-beta.9',
        ], $this->reset);

        $this->line($number,'Archivo package.json actualizado (dependencies)');

        return $this;
    }

    public function modifyFile_PackageJson_toAddScriptTsBuild($number): self
    {
        // Add script "ts-build" in "package.json"
        $this->modifyPackageJsonSection('scripts', [
            'ts-build' => 'tsc && vite build',
        ], $this->reset);

        $this->line($number,'Archivo package.json actualizado (script "ts-build")');

        return $this;
    }

    public function modifyFile_ComposerJson_toAddSrcNamespace($number): self
    {
        // Update the "autoload.psr-4" section in "composer.json" file with additional namespaces.
        // Add the "Src" namespace into "composer.json"

        $namespaces = ['Src\\' => 'src/'];

        $filePath = base_path('composer.json');

        if (!file_exists($filePath)) {
            return $this;
        }

        $composer = json_decode(file_get_contents($filePath), true);

        if (!isset($composer['autoload']['psr-4'])) {
            $composer['autoload']['psr-4'] = [];
        }

        $psr4 = $composer['autoload']['psr-4'];

        if ($this->reset) {
            // Eliminamos los namespaces especificados
            foreach ($namespaces as $namespace => $path) {
                unset($composer['autoload']['psr-4'][$namespace]);
            }
        } else {
            // Añadimos los nuevos namespaces
            $composer['autoload']['psr-4'] = $namespaces + $psr4;
            ksort($composer['autoload']['psr-4']);
        }

        // Convertir el arreglo a JSON y formatear con JSON_PRETTY_PRINT
        $jsonContent = json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

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

        // Guardamos los cambios en composer.json
        file_put_contents($filePath, $jsonContent . PHP_EOL);


        $this->line($number,'Namespace "Src" añadido al "composer.json"');

        return $this;
    }

    public function execute_ComposerRequire_toInstallComposerDependencies($number): self
    {
        // Install "tightenco/ziggy"

        $content = file_get_contents(base_path('composer.json'));

        $packages = ['tightenco/ziggy'];
        $package1 = $packages[0];

        if ($this->reset) {
            if (!str_contains($content, $package1)) {
                return $this;
            }

            $this->command->removeComposerPackages(
                $this->command->option('composer'),
                $packages
            );

            $this->line($number,'Dependencias de composer desinstaladas');

            return $this;
        }

        if (str_contains($content, $package1)) {
            return $this;
        }

        $this->command->executeRequireComposerPackages(
            $this->command->option('composer'),
            $packages
        );

        $this->line($number,'Dependencias de composer instaladas');

        return $this;
    }

    /*public function execute_ComposerDumpAutoload($number): self
    {
        // Execute the "composer dump-autoload" command

        if ($this->packageInDevelop) {
            return $this;
        }

        $run = Process::run('composer dump-autoload');
        if ($run->failed()) {
            $this->command->warn('The command "composer dump-autoload" has failed');
        } else {
            $this->line($number,'Command "composer dump-autoload" successfully.');
        }

        return $this;
    }*/

    public function execute_NpmInstall($number): self
    {
        if ($this->packageInDevelop) return $this;

        $this->execute_Process(
            $number,
            ['npm', 'install'],
            'Installing Node dependencies.',
            'Node dependencies installed successfully.',
            'Node dependency installation failed.'
        );

        return $this;
    }

    public function execute_NpmRunBuild($number): self
    {
        if ($this->packageInDevelop) return $this;

        $this->execute_Process(
            $number,
            ['npm', 'run', 'build'],
            'Building app.',
            'App built successfully.',
            'Build failed.'
        );

        return $this;
    }

}