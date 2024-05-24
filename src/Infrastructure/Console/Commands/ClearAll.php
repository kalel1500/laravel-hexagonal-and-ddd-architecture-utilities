<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

final class ClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all the cache';

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
//        Artisan::call('cache:clear');
//        $this->info('cache:clear');

//        Artisan::call('config:clear');
//        $this->info('config:clear');

//        Artisan::call('event:clear');
//        $this->info('event:clear');

//        Artisan::call('route:clear');
//        $this->info('route:clear');

//        Artisan::call('view:clear');
//        $this->info('view:clear');

//        Artisan::call('schedule:clear-cache');
//        $this->info('schedule:clear-cache');

//        Artisan::call('debugbar:clear');
//        $this->info('debugbar:clear');

//        Artisan::call('clear-compiled');
//        $this->info('clear-compiled');

        Artisan::call('optimize:clear');
        $this->info('optimize:clear');

        Artisan::call('logs:clear');
        $this->info('logs:clear');


        $this->info('All cache files are cleared');
    }
}
