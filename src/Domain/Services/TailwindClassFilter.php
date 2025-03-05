<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services;

final class TailwindClassFilter {
    protected array $specials = [
        'display' => [
            'block',
            'inline-block',
            'inline',
            'flex',
            'inline-flex',
            'table',
            'inline-table',
            'table-caption',
        ],
        'position' => [
            'static',
            'fixed',
            'absolute',
            'relative',
            'sticky',
        ],
    ];

    public function __construct(array $specials = null) {
        if ($specials !== null) {
            $this->specials = $specials;
        }
    }

    /**
     * Filtra las clases por defecto eliminando aquellas que tengan equivalentes
     * en las clases personalizadas.
     *
     * @param string $default_classes
     * @param string $custom_classes
     * @return string
     */
    public function filter(string $default_classes, string $custom_classes): string
    {
        // Convertimos las cadenas en arrays
        $default_array = explode(' ', trim($default_classes));
        $custom_array  = explode(' ', trim($custom_classes));
        $custom_special_found = $this->getCustomSpecialMap($custom_array);

        $filtered = [];
        foreach ($default_array as $default_class) {
            if (empty($default_class)) continue;
            if ($this->shouldKeepClass($default_class, $custom_array, $custom_special_found)) {
                $filtered[] = $default_class;
            }
        }

        return implode(' ', $filtered);
    }

    /**
     * Construye un mapa indicando si en $custom_array existe alguna clase
     * perteneciente a cada grupo especial definido en $specials.
     *
     * @param array $custom_array
     * @return array
     */
    protected function getCustomSpecialMap(array $custom_array): array
    {
        $map = [];
        foreach ($this->specials as $groupKey => $classList) {
            $found = array_intersect($custom_array, $classList);
            $map[$groupKey] = !empty($found);
        }
        return $map;
    }

    /**
     * Determina si se debe conservar la clase por defecto, comparándola con
     * las clases personalizadas y usando el mapa de especiales.
     *
     * @param string $default_class
     * @param array  $custom_array
     * @param array  $custom_special_found
     * @return bool
     */
    protected function shouldKeepClass(string $default_class, array $custom_array, array $custom_special_found): bool
    {
        $parsed = $this->parseClass($default_class);

        // Si tiene variante, se compara solo con las clases custom que también tengan variante.
        if ($parsed['variant'] !== '') {
            foreach ($custom_array as $custom_class) {
                if (strpos($custom_class, ':') !== false) {
                    $custom_parsed = $this->parseClass($custom_class);
                    if (
                        $custom_parsed['variant'] === $parsed['variant'] &&
                        $custom_parsed['group'] === $parsed['group'] &&
                        $custom_parsed['prefix'] === $parsed['prefix']
                    ) {
                        return false;
                    }
                }
            }
            return true;
        }

        // Para clases sin variante: primero comprobamos si es parte de algún grupo especial.
        foreach ($this->specials as $groupKey => $classList) {
            if (in_array($default_class, $classList)) {
                return !$custom_special_found[$groupKey];
            }
        }

        // Para el resto, comparamos según el grupo y el prefijo.
        foreach ($custom_array as $custom_class) {
            if (strpos($custom_class, ':') === false) {
                $custom_parsed = $this->parseClass($custom_class);
                if (
                    $parsed['group'] === $custom_parsed['group'] &&
                    $parsed['prefix'] === $custom_parsed['prefix']
                ) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Parsea una clase de Tailwind extrayendo:
     * - variante: lo que está antes de ":" (o cadena vacía si no existe)
     * - base: lo que sigue después
     * - group: número de partes al separar la base por "-"
     * - prefix: la primera parte de la base
     *
     * @param string $class
     * @return array
     */
    protected function parseClass(string $class): array
    {
        if (strpos($class, ':') !== false) {
            // Separamos en dos partes: variante y el resto.
            list($variant, $base) = explode(':', $class, 2);
        } else {
            $variant = '';
            $base = $class;
        }
        // Dividimos la parte base por '-' para contar el grupo y obtener el prefijo.
        $parts = explode('-', $base);
        return [
            'variant' => $variant,
            'base'    => $base,
            'group'   => count($parts), // // Número de partes (ejemplo: 2 para "text-md", 3 para "text-blue-500")
            'prefix'  => $parts[0],
        ];
    }

}
