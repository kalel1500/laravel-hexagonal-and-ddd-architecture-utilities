<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Thehouseofel\Hexagonal\Application\GetAllFailedJobsUseCase;
use Thehouseofel\Hexagonal\Application\GetAllJobsUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Repositories\JobEloquentRepository;
use Throwable;

final class AjaxJobsController extends Controller
{
    private $jobEloquentRepository;

    public function __construct(JobEloquentRepository $jobEloquentRepository)
    {
        $this->jobEloquentRepository = $jobEloquentRepository;
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function getJobs(): JsonResponse
    {
        try {
            $getAllJobsUseCase = new GetAllJobsUseCase($this->jobEloquentRepository);
            $jobs = $getAllJobsUseCase->__invoke();
            return responseJson(true, 'success', ['jobs' => $jobs->toArray()]);
        } catch (Throwable $th) {
            return responseJsonError($th);
        }
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function getFailedJobs(): JsonResponse
    {
        try {
            $getAllFailedJobsUseCase = new GetAllFailedJobsUseCase($this->jobEloquentRepository);
            $jobs = $getAllFailedJobsUseCase->__invoke();
            return responseJson(true, 'success', ['jobs' => $jobs->toArray()]);
        } catch (Throwable $th) {
            return responseJsonError($th);
        }
    }
}
