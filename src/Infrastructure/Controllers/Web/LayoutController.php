<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers\Web;

use Illuminate\Support\Facades\File;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Controller;

final class LayoutController extends Controller
{
    public function public($file)
    {
        // Determina el tipo de contenido en función de la extensión del archivo
        $contentType = str_ends_with($file, '.css') ? 'text/css' : 'application/javascript';

        // Obtener el path generado del archivo con hash
        $hashedFilePath = HEXAGONAL_PATH . '/public/build/assets/'.$file;

        // Comprobar que el archivo con hash existe
        if (File::exists($hashedFilePath)) {
            return response()->file($hashedFilePath, ['Content-Type' => $contentType]);
        }

        abort(404);
    }
}
