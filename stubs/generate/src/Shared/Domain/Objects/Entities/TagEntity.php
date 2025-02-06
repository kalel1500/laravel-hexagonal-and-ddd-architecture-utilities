<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Objects\Entities;

use Src\Shared\Domain\Objects\Entities\Collections\PostCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\ContractEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class TagEntity extends ContractEntity
{
    public function __construct(
        public readonly ContractModelId $id,
        public readonly ModelString     $name,
        public readonly ModelString     $code,
    )
    {
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            ModelId::from($data['id']),
            ModelString::new($data['name']),
            ModelString::new($data['code']),
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'      => $this->id->value(),
            'content' => $this->name->value(),
            'post_id' => $this->code->value(),
        ];
    }

    public function posts(): PostCollection
    {
        return $this->getRelation('posts');
    }

    public function setPosts(array $value): void
    {
        $this->setRelation($value, 'posts', PostCollection::class);
    }
}
