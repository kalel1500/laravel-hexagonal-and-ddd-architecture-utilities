<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Application;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Icons\IconDo;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Icons\ViewIconsDo;

final class GetIconsUseCase
{
    public function __invoke(bool $showNameShort): ViewIconsDo
    {
        // Ruta a la carpeta de iconos
        $iconPath = HEXAGONAL_PATH . '/resources/views/components/icon';

        if (!is_dir($iconPath)) {
            abort(404, "La carpeta de iconos no se encontró en: $iconPath");
        }

        // Obtener todos los archivos Blade de la carpeta
        $icons = collect(File::files($iconPath))
            ->filter(function ($file) {
                return $file->getExtension() === 'php'; // Aseguramos que sean PHP (Blade)
            })
            ->map(function ($file) {
                // Extraer el nombre del componente en kebab-case
                $prefix = 'hexagonal::icon.';
                $name = Str::kebab($file->getBasename('.blade.php'));
                return IconDo::fromArray(['name' => $prefix . $name, 'name_short' => $name]);
            });

        return ViewIconsDo::fromArray([
            'icons' => $icons->toArray(),
            'show_name_short' => $showNameShort,
        ]);
    }
}
