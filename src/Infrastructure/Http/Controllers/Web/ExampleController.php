<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class ExampleController extends Controller
{
    public function example1(): View
    {
        return view('hexagonal::pages.examples.example1');
    }

    public function example2(): View
    {
        return view('hexagonal::pages.examples.example2');
    }

    public function example3(): View
    {
        return view('hexagonal::pages.examples.example3');
    }

    public function example4(): View
    {
        return view('hexagonal::pages.examples.example4');
    }

    public function compareHtml(): View
    {
        return view('hexagonal::pages.examples.compare-html');
    }

    public function modifyCookie(): View
    {
        return view('hexagonal::pages.examples.modify-cookie');
    }
}
