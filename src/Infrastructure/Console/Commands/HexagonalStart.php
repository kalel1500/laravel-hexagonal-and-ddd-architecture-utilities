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

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->stubsPath = HEXAGONAL_PATH.'/stubs/generate';
    }

    public function filesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function stubsPath(): string
    {
        return $this->stubsPath;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        StartCommandService::configure($this)
            ->publishHexagonalConfig()
            ->stubsCopyFile_AppServiceProvider()
            ->stubsCopyFile_DependencyServiceProvider()
            ->stubsCopyFolder_Views()
            ->stubsCopyFolder_Src()
            ->createEnvFiles()
            ->deleteDirectory_Http()
            ->deleteDirectory_Models()
            ->deleteFile_Changelog()
            ->addDependencyServiceProviderToBootstrapFile()
            ->addHexagonalExceptionHandlerInBootstrapApp()
            ->stubsCopyFile_RoutesWeb()
            ->commentUserFactoryInDatabaseSeeder()
            ->addImportFlowbiteInBootstrapJs()
            ->stubsCopyFile_tailwindConfigJs()
            ->deleteLockFilesFromGitignore()
            ->addNpmDevDependenciesInPackageJsonFile()
            ->addScriptTsBuildInPackageJsonFile()
            ->installComposerDependencies()
            ->addNamespacesInComposerJson()
            ->executeComposerDumpAutoload()
            ->installNodeDependencies();
    }
}
