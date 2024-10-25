<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers\Web;

use Thehouseofel\Hexagonal\Infrastructure\Controllers\Controller;

final class JobsController extends Controller
{
    public function queuedJobs(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::pages.jobs');
    }

    public function failedJobs(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::pages.jobs');
    }
}
