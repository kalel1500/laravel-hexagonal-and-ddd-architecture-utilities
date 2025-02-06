<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Objects\Entities;

use Src\Shared\Domain\Objects\Entities\Collections\CommentCollection;
use Src\Shared\Domain\Objects\Entities\Collections\PostCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\ContractEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

class UserEntity extends ContractEntity
{
    public function __construct(
        public readonly ContractModelId $id,
        public readonly ModelString     $name,
        public readonly ModelString     $email,
        public readonly ModelStringNull $email_verified_at,
    )
    {
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            ModelId::from($data['id']),
            ModelString::new($data['name']),
            ModelString::new($data['email']),
            ModelStringNull::new($data['email_verified_at']),
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'                => $this->id->value(),
            'content'           => $this->name->value(),
            'email'             => $this->email->value(),
            'email_verified_at' => $this->email_verified_at->value(),
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

    public function comments(): CommentCollection
    {
        return $this->getRelation('comments');
    }

    public function setComments(array $value): void
    {
        $this->setRelation($value, 'comments', CommentCollection::class);
    }
}
