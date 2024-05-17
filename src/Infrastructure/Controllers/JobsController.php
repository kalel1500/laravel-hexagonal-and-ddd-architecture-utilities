<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers;

use Illuminate\Contracts\View\View;
use Thehouseofel\Hexagonal\Application\GetAllFailedJobsUseCase;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Views\ViewFailedJobsDo;
use Thehouseofel\Hexagonal\Infrastructure\Repositories\JobEloquentRepository;

final class JobsController extends Controller
{
    private $jobEloquentRepository;

    public function __construct(JobEloquentRepository $jobEloquentRepository)
    {
        $this->jobEloquentRepository = $jobEloquentRepository;
    }

    public function failedJobs(): View
    {
        $getAllFailedJobsUseCase = new GetAllFailedJobsUseCase($this->jobEloquentRepository);
        $jobs = $getAllFailedJobsUseCase();
        $viewData = new ViewFailedJobsDo($jobs);
        return view('pages.app.config.jobs.failed-jobs', compact('viewData'));
    }
}
