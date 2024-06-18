<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers;


use Illuminate\Support\Facades\View;

final class JobsController extends Controller
{
    public function queuedJobs(): \Illuminate\Contracts\View\View
    {
        return View::file(__DIR__.'/../../../resources/views/queues/jobs.blade.php');
    }

    public function failedJobs(): \Illuminate\Contracts\View\View
    {
        return View::file(__DIR__.'/../../../resources/views/queues/jobs.blade.php');
    }
}
