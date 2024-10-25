<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Controllers\Web;

use Illuminate\Support\Facades\File;
use Thehouseofel\Hexagonal\Infrastructure\Controllers\Controller;

final class LayoutController extends Controller
{
    public function public($file)
    {
        // Ruta al archivo manifest.json del paquete
        $manifestPath = HEXAGONAL_PATH . '/public/build/manifest.json';

        // Comprobar que el archivo manifest existe
        if (!File::exists($manifestPath)) {
            abort(404, 'Manifest file not found.');
        }

        // Leer y decodificar el manifest.json
        $manifest = json_decode(File::get($manifestPath), true);

        // Verificar si el archivo solicitado está en el manifest
        if (isset($manifest[$file])) {
            // Obtener el path generado del archivo con hash
            $hashedFilePath = HEXAGONAL_PATH . '/public/build/' . $manifest[$file]['file'];

            // Comprobar que el archivo con hash existe
            if (File::exists($hashedFilePath)) {
                return response()->file($hashedFilePath);
            }
        }

        abort(404);
    }
}
