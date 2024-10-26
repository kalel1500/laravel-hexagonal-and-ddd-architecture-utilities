<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers\Web;

use Thehouseofel\Hexagonal\Infrastructure\Controllers\Controller;

final class TestController extends Controller
{
    public function testVitePackage(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::pages.tests.test-vite-package');
    }
}
