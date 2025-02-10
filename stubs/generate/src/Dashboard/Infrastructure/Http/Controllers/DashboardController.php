<?php

declare(strict_types=1);

namespace Src\Dashboard\Infrastructure\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Src\Dashboard\Application\GetDashboardDataUseCase;
use Src\Dashboard\Application\GetPostDataUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class DashboardController extends Controller
{
    public function __construct(
        public readonly GetDashboardDataUseCase $getDashboardDataUseCase,
        public readonly GetPostDataUseCase $getPostDataUseCase,
    )
    {
    }

    public function dashboard(Request $request): View
    {
        $data = $this->getDashboardDataUseCase->__invoke($request->input('tag'));
        return view('pages.dashboard.index', compact('data'));
    }

    public function post(string $slug): View
    {
        $post = $this->getPostDataUseCase->__invoke($slug);
        return view('pages.dashboard.post', compact('post'));
    }
}
