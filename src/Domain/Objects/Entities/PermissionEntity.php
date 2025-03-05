<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities;

use Thehouseofel\Kalion\Domain\Objects\Entities\Collections\RoleCollection;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class PermissionEntity extends ContractEntity
{
    public ContractModelId $id;
    public ModelString     $name;
    public function __construct(
        ContractModelId $id,
        ModelString     $name
    )
    {
        $this->id              = $id;
        $this->name            = $name;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            ModelId::from($data['id'] ?? null),
            ModelString::new($data['name']),
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'          => $this->id->value(),
            'name'        => $this->name->value(),
        ];
    }

    public function roles(): RoleCollection
    {
        return $this->getRelation('roles');
    }

    public function setRoles(array $value): void
    {
        $this->setRelation($value, 'roles', RoleCollection::class);
    }

}
