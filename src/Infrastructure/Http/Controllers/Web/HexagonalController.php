<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web;

use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class HexagonalController extends Controller
{
    public function root()
    {
        return redirect('/');
    }

    public function testVitePackage(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::pages.tests.test-vite-package');
    }
}
