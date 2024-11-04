<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Traits;

trait WithIdsAndToArray
{
    // Método para obtener el ID asociado a un valor del enum
    public function getId(): int {
        return static::values()[$this->value];
    }

    // Método para convertir todos los valores del enum en un array de strings
    public static function toArray(): array {
        return array_map(function ($case) {return $case->value;}, static::cases()); // TODO PHP8 - array_map(fn($case) => $case->value, static::cases());
    }
}