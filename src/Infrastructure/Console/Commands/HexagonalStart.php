<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\InteractsWithComposerPackages;
use Thehouseofel\Hexagonal\Infrastructure\Services\StartCommandService;

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
    protected $originalStubsPath;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->stubsPath = HEXAGONAL_PATH.'/stubs/generate';
        $this->originalStubsPath = HEXAGONAL_PATH.'/stubs/original';
    }

    public function filesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function stubsPath(): string
    {
        return $this->stubsPath;
    }

    public function originalStubsPath(): string
    {
        return $this->originalStubsPath;
    }

    public function executeRequireComposerPackages(...$params)
    {
        $this->requireComposerPackages(...$params);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        StartCommandService::configure($this)
            ->restoreFilesModifiedByPackageLaravelTsUtils()
            ->publishHexagonalConfig()
            ->stubsCopyFile_AppServiceProvider()
            ->stubsCopyFile_DependencyServiceProvider()
            ->stubsCopyFolder_Views()
            ->stubsCopyFolder_Src()
            ->stubsCopyFile_RoutesWeb()
            ->stubsCopyFile_tailwindConfigJs()
            ->createEnvFiles()
            ->deleteDirectory_Http()
            ->deleteDirectory_Models()
            ->deleteFile_Changelog()
            ->modifyFile_BootstrapProviders_toAddDependencyServiceProvider()
            ->modifyFile_BootstrapApp_toAddExceptionHandler()
            ->modifyFile_DatabaseSeeder_toCommentUserFactory() // ¿pasar a copy?
            ->modifyFile_JsBootstrap_toAddImportFlowbite() // ¿pasar a copy?
            ->modifyFile_Gitignore_toDeleteLockFileLines()
            ->modifyFile_PackageJson_toAddNpmDevDependencies()
            ->modifyFile_PackageJson_toAddScriptTsBuild()
            ->execute_ComposerRequire_toInstallComposerDependencies()
            ->modifyFile_ComposerJson_toAddSrcNamespace()
            ->execute_ComposerDumpAutoload()
            ->execute_NpminstallAndNpmRunBuild();
    }
}
