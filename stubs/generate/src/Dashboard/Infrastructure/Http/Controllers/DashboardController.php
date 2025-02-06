<?php

declare(strict_types=1);

namespace Src\Dashboard\Infrastructure\Http\Controllers;

use Illuminate\Contracts\View\View;
use Src\Dashboard\Application\GetDashboardDataUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class DashboardController extends Controller
{
    public function __construct(
        public readonly GetDashboardDataUseCase $getDashboardDataUseCase
    )
    {
    }

    public function dashboard(): View
    {
        $data = $this->getDashboardDataUseCase->__invoke();
        return view('pages.dashboard.index', compact('data'));
    }
}
