<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Objects\Entities;

use Src\Shared\Domain\Objects\Entities\Collections\CommentCollection;
use Src\Shared\Domain\Objects\Entities\Collections\TagCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\ContractEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class PostEntity extends ContractEntity
{
    public function __construct(
        public readonly ContractModelId $id,
        public readonly ModelString     $title,
        public readonly ModelString     $content,
        public readonly ModelId         $user_id,
    )
    {
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            ModelId::from($data['id']),
            ModelString::new($data['title']),
            ModelString::new($data['content']),
            ModelId::new($data['user_id']),
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'      => $this->id->value(),
            'title'   => $this->title->value(),
            'content' => $this->content->value(),
            'user_id' => $this->user_id->value(),
        ];
    }

    public function user(): ?UserEntity
    {
        return $this->getRelation('user');
    }

    public function setUser(?array $value): void
    {
        $this->setRelation($value, 'user', UserEntity::class);
    }

    public function comments(): CommentCollection
    {
        return $this->getRelation('comments');
    }

    public function setComments(array $value): void
    {
        $this->setRelation($value, 'comments', CommentCollection::class);
    }

    public function tags(): TagCollection
    {
        return $this->getRelation('tags');
    }

    public function setTags(array $value): void
    {
        $this->setRelation($value, 'tags', TagCollection::class);
    }
}
