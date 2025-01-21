<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Http\Controllers;

use Illuminate\Contracts\View\View;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class DefaultController extends Controller
{
    public function home(): View
    {
        return view('pages.default.home');
    }
}
