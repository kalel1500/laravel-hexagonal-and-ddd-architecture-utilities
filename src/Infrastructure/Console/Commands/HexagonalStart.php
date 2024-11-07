<?php

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
    }
}
