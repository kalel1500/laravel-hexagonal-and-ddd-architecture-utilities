<?php

declare(strict_types=1);

namespace Src\Admin\Infrastructure\Http\Controllers;

use Illuminate\Contracts\View\View;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class AdminController extends Controller
{
    public function tags(): View
    {
        return view('pages.admin.tags');
    }
}
