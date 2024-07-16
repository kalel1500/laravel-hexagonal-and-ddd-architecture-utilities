<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers;

final class JobsController extends Controller
{
    public function queuedJobs(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::jobs');
    }

    public function failedJobs(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::jobs');
    }
}
