<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordNotFoundException;
use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Src\Shared\Domain\Objects\Entities\Collections\TagCollection;
use Src\Shared\Domain\Objects\Entities\TagEntity;
use Src\Shared\Infrastructure\Models\Tag;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

final class TagRepository implements TagRepositoryContract
{
    private string $model;

    public function __construct()
    {
        $this->model = Tag::class;
    }

    public function all(): TagCollection
    {
        $data = $this->model::query()->get();
        return TagCollection::fromArray($data->toArray());
    }

    public function searchByType(ModelStringNull $typeCode): TagCollection
    {
        $data = $this->model::query()
            ->where(function (Builder $query) use ($typeCode) {
                if ($typeCode->isNotNull()) {
                    $query->whereHas('tagType', function (Builder $query2) use ($typeCode) {
                        $query2->where('code', $typeCode->value());
                    });
                }
            })
            ->get();
        return TagCollection::fromArray($data->toArray());
    }

    public function create(TagEntity $tag): void
    {
        $this->model::query()->create($tag->toArrayDb());
    }

    public function update(TagEntity $tag): void
    {
        try {
            $this->model::query()
                ->findOrFail($tag->id->value())
                ->update($tag->toArrayDb());
        } catch (ModelNotFoundException $e) {
            throw new RecordNotFoundException($e->getMessage());
        }
    }

    public function delete(ModelId $id): void
    {
        try {
            $this->model::query()
                ->findOrFail($id->value())
                ->delete();
        } catch (ModelNotFoundException $e) {
            throw new RecordNotFoundException($e->getMessage());
        }
    }
}
