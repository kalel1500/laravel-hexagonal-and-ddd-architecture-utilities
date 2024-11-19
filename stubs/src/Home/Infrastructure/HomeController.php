<?php

declare(strict_types=1);

namespace Src\Home\Infrastructure;

use Illuminate\Contracts\View\View;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home.index');
    }
}
