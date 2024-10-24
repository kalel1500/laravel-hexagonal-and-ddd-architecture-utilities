<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers;

final class TestController extends Controller
{
    public function test(): \Illuminate\Contracts\View\View
    {
        return view('hexagonal::test');
    }
}
