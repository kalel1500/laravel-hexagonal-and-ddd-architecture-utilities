<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers\Web;

use Thehouseofel\Hexagonal\Infrastructure\Controllers\Controller;

final class LayoutController extends Controller
{
    public function public($type, $file)
    {
        $path = HEXAGONAL_PATH . "/public/{$type}/{$file}";

        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    }
}