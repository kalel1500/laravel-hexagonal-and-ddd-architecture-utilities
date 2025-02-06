<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Thehouseofel\Hexagonal\Infrastructure\Services\StartCommandService;
use Thehouseofel\Hexagonal\Infrastructure\Traits\InteractsWithComposerPackages;
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
                    {--reset : Reset all changes made by the command to the original state}
                    {--simple : Create only the files needed for the backend}';

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

    public function traitRequireComposerPackages(string $composer, array $packages, bool $isRemove = false)
    {
        $this->requireComposerPackages($composer, $packages, $isRemove);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reset = $this->option('reset');
        $simple = $this->option('simple');

        $this->info('Inicio configuración:');

        StartCommandService::configure($this, $reset, $simple)
            ->restoreFilesModifiedByPackageLaravelTsUtils()
            ->publishHexagonalConfig()
            ->stubsCopyFile_AppServiceProvider()
            ->stubsCopyFile_DependencyServiceProvider()
            ->stubsCopyFiles_Migrations()
            ->stubsCopyFolder_Factories()
            ->stubsCopyFolder_Lang()
            ->stubsCopyFolder_Resources()
            ->stubsCopyFolder_Src()
            ->stubsCopyFile_RoutesWeb()
            ->stubsCopyFile_tailwindConfigJs()
            ->createEnvFiles()
            ->deleteDirectory_Http()
            ->deleteDirectory_Models()
            ->deleteFile_Changelog()
            ->modifyFile_BootstrapProviders_toAddDependencyServiceProvider()
            ->modifyFile_BootstrapApp_toAddMiddlewareRedirect()
            ->modifyFile_BootstrapApp_toAddExceptionHandler()
            ->modifyFile_ConfigAuth_toUpdateModel()
            ->modifyFile_DatabaseSeeder_toCommentUserFactory()
            ->modifyFile_JsBootstrap_toAddImportFlowbite()
            ->modifyFile_Gitignore_toDeleteLockFileLines()
            ->modifyFile_PackageJson_toAddNpmDevDependencies()
            ->modifyFile_PackageJson_toAddNpmDependencies()
            ->modifyFile_PackageJson_toAddScriptTsBuild()
            ->modifyFile_ComposerJson_toAddSrcNamespace()
            ->execute_ComposerRequire_toInstallComposerDependencies()
            ->execute_NpmInstall()
            ->execute_NpxLaravelTsUtils()
            ->execute_gitAdd()
            ->execute_NpmRunBuild();

        $this->info('Configuración finalizada');

    }
}
