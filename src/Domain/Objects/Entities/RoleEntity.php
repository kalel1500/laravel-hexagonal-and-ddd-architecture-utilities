<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities;

use Thehouseofel\Kalion\Domain\Objects\Entities\Collections\PermissionCollection;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelBool;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class RoleEntity extends ContractEntity
{
    public ContractModelId $id;
    public ModelString     $name;
    public ModelBool       $all_permissions;
    public ModelBool       $is_query;

    public function __construct(
        ContractModelId $id,
        ModelString     $name,
        ModelBool       $all_permissions,
        ModelBool       $is_query
    )
    {
        $this->id              = $id;
        $this->name            = $name;
        $this->all_permissions = $all_permissions;
        $this->is_query        = $is_query;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            ModelId::from($data['id'] ?? null),
            ModelString::new($data['name']),
            ModelBool::new($data['all_permissions']),
            ModelBool::new($data['is_query'])
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'              => $this->id->value(),
            'name'            => $this->name->value(),
            'all_permissions' => $this->all_permissions->value(),
            'is_query'        => $this->is_query->value(),
        ];
    }

    public function permissions(): PermissionCollection
    {
        return $this->getRelation('permissions');
    }

    public function setPermissions(array $value): void
    {
        $this->setRelation($value, 'permissions', PermissionCollection::class);
    }

}
