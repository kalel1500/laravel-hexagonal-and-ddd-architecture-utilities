<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services;

final class TailwindClassFilter {
    protected array $specials = [
        'position' => [
            'static',
            'fixed',
            'absolute',
            'relative',
            'sticky',
        ],
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

        $filtered = [];
        foreach ($default_array as $default_class) {
            if (empty($default_class)) continue;
            if ($this->shouldKeepClass($default_class, $custom_array)) {
                $filtered[] = $default_class;
            }
        }

        return implode(' ', $filtered);
    }

    /**
     * Determina si se debe conservar la clase por defecto.
     *
     * La lógica es:
     * - Se filtran las clases custom para considerar solo las que tengan (o no) variante según la clase default.
     * - Si la clase es especial (display, position, etc.), se elimina si en custom existe cualquier clase
     *   del mismo grupo especial.
     * - Si no es especial, se elimina si hay en custom alguna clase que tenga el mismo número de partes (group)
     *   y el mismo prefijo.
     *
     * @param string $default_class
     * @param array $custom_array
     * @return bool
     */
    protected function shouldKeepClass(string $default_class, array $custom_array): bool
    {
        $defaultSpecial = $this->getSpecialGroup($default_class);
        $parsed = $this->parseClass($default_class);

        // Filtrar las clases custom relevantes según si la default tiene variante o no.
        $filteredCustom = array_filter($custom_array, function($custom_class) use ($parsed) {
            $customHasVariant = strpos($custom_class, ':') !== false;
            if ($parsed['variant'] !== '') {
                // Si la clase default tiene variante, consideramos solo las custom que tengan la misma variante.
                return $customHasVariant && (strpos($custom_class, $parsed['variant'] . ':') === 0);
            }
            // Si no tiene variante, tomamos solo las custom sin variante.
            return !$customHasVariant;
        });

        foreach ($filteredCustom as $custom_class) {
            $customParsed = $this->parseClass($custom_class);
            if ($defaultSpecial !== false) {
                // Para clases especiales, si en custom aparece alguna clase del mismo grupo, se elimina.
                if (in_array($customParsed['base'], $this->specials[$defaultSpecial])) {
                    return false;
                }
            } else {
                // Para el resto, se compara el número de partes y el prefijo.
                if ($parsed['group'] === $customParsed['group'] && $parsed['prefix'] === $customParsed['prefix']) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Verifica si la clase pertenece a un grupo especial (por ejemplo, display o position).
     * Devuelve el nombre del grupo o false si no pertenece a ninguno.
     *
     * @param string $class
     * @return mixed
     */
    protected function getSpecialGroup(string $class) {
        $parsed = $this->parseClass($class);
        foreach ($this->specials as $groupKey => $classList) {
            if (in_array($parsed['base'], $classList)) {
                return $groupKey;
            }
        }
        return false;
    }

    /**
     * Descompone una clase de Tailwind en:
     * - variant: parte antes de ":" (vacía si no existe)
     * - base: parte después de ":" o la clase completa si no hay variante
     * - group: cantidad de partes al dividir la base por "-"
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
