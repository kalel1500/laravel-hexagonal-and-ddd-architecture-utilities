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
     * Determina si se debe conservar la clase por defecto, comparándola con
     * las clases personalizadas.
     *
     * La lógica es:
     * - Si la clase (default) es "especial" (por ejemplo, de display o position) se elimina si existe alguna clase en custom que pertenezca al mismo grupo y, en caso de variante, que tenga la misma variante.
     * - Si no es especial se compara según el número de partes y el prefijo.
     *
     * @param string $default_class
     * @param array  $custom_array
     * @return bool
     */
    protected function shouldKeepClass(string $default_class, array $custom_array): bool
    {
        $parsed = $this->parseClass($default_class);
        $defaultSpecial = $this->getSpecialGroup($default_class);

        // Si la clase tiene variante
        if ($parsed['variant'] !== '') {
            if ($defaultSpecial !== false) {
                // Si es especial, se busca en las custom clases con la misma variante
                foreach ($custom_array as $custom_class) {
                    if (strpos($custom_class, ':') !== false) {
                        $customParsed = $this->parseClass($custom_class);
                        if ($customParsed['variant'] === $parsed['variant'] &&
                            in_array($customParsed['base'], $this->specials[$defaultSpecial])) {
                            return false;
                        }
                    }
                }
            } else {
                // Si no es especial, se compara variant, group y prefix
                foreach ($custom_array as $custom_class) {
                    if (strpos($custom_class, ':') !== false) {
                        $customParsed = $this->parseClass($custom_class);
                        if (
                            $customParsed['variant'] === $parsed['variant'] &&
                            $customParsed['group'] === $parsed['group'] &&
                            $customParsed['prefix'] === $parsed['prefix']
                        ) {
                            return false;
                        }
                    }
                }
            }
            return true;
        } else {
            // Para clases sin variante
            if ($defaultSpecial !== false) {
                // Si es especial, se elimina si en custom existe alguna clase (sin variante) del mismo grupo
                foreach ($custom_array as $custom_class) {
                    if (strpos($custom_class, ':') === false) {
                        if (in_array($custom_class, $this->specials[$defaultSpecial])) {
                            return false;
                        }
                    }
                }
            } else {
                // Para clases no especiales, se compara según group y prefix
                foreach ($custom_array as $custom_class) {
                    if (strpos($custom_class, ':') === false) {
                        $customParsed = $this->parseClass($custom_class);
                        if (
                            $parsed['group'] === $customParsed['group'] &&
                            $parsed['prefix'] === $customParsed['prefix']
                        ) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }
    }

    /**
     * Verifica si la clase pertenece a un grupo especial.
     * Devuelve el nombre del grupo si es especial, o false si no lo es.
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
     * Parsea una clase de Tailwind extrayendo:
     * - variant: lo que está antes de ":" (o cadena vacía si no existe)
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
