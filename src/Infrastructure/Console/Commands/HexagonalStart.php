<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\InteractsWithComposerPackages;
use Symfony\Component\Process\Process;
use Thehouseofel\Hexagonal\Infrastructure\Services\StartCommandService;
use function Illuminate\Filesystem\join_paths;

class HexagonalStart extends Command
{
    use InteractsWithComposerPackages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hexagonal:start
                    {--composer=global : Absolute path to the Composer binary which should be used to install packages}
                    {--reset : Reset all changes made by the command to the original state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create starter files for hexagonal architecture';

    protected $filesystem;
    protected $stubsPath;
    protected $originalStubsPath;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->stubsPath = HEXAGONAL_PATH . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'generate';
        $this->originalStubsPath = HEXAGONAL_PATH . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'original';
    }

    public function filesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function stubsPath($path = ''): string
    {
        return join_paths($this->stubsPath, $path);
    }

    public function originalStubsPath($path = ''): string
    {
        return join_paths($this->originalStubsPath, $path);
    }

    public function executeRequireComposerPackages(...$params)
    {
        $this->requireComposerPackages(...$params);
    }

    public function removeComposerPackages(string $composer, array $packages): bool
    {
        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
        );

        return ! (new Process($command, $this->laravel->basePath(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reset = $this->option('reset');

        $this->info('Inicio configuración:');

        StartCommandService::configure($this, $reset, 21)
            ->restoreFilesModifiedByPackageLaravelTsUtils(1)
            ->publishHexagonalConfig(2)
            ->stubsCopyFile_AppServiceProvider(3)
            ->stubsCopyFile_DependencyServiceProvider(4)
            ->stubsCopyFolder_Views(5)
            ->stubsCopyFolder_Src(6)
            ->stubsCopyFile_RoutesWeb(7)
            ->stubsCopyFile_tailwindConfigJs(8)
            ->createEnvFiles(9)
            ->deleteDirectory_Http(10)
            ->deleteFile_Changelog(11)
            ->modifyFile_BootstrapProviders_toAddDependencyServiceProvider(12)
            ->modifyFile_BootstrapApp_toAddExceptionHandler(13)
            ->modifyFile_DatabaseSeeder_toCommentUserFactory(14)
            ->modifyFile_JsBootstrap_toAddImportFlowbite(15)
            ->modifyFile_Gitignore_toDeleteLockFileLines(16)
            ->modifyFile_PackageJson_toAddNpmDevDependencies(17)
            ->modifyFile_PackageJson_toAddNpmDependencies(18)
            ->modifyFile_PackageJson_toAddScriptTsBuild(19)
            ->modifyFile_ComposerJson_toAddSrcNamespace(20)
            ->execute_ComposerRequire_toInstallComposerDependencies(21)
            ->execute_NpminstallAndNpmRunBuild(22);

        $this->info('Configuración finalizada');

    }
}
