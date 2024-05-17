<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogsClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear log files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
//            exec('rm ' . storage_path('logs/*.log'));
            exec('echo "" > ' . storage_path('logs/laravel.log'));
            exec('chmod -R 777 ' . storage_path());
            Log::info('Logs limpios');
            $this->comment('Logs have been cleared!');
        } catch (Throwable $exception) {
//            $message = 'El comando "rm" no existe';
            $message = $exception->getMessage();
            Log::warning($message);
            $this->comment($message);
        }
    }
}
