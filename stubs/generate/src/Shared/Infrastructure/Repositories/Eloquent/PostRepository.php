<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Src\Shared\Domain\Contracts\Repositories\PostRepositoryContract;
use Src\Shared\Domain\Objects\Entities\Collections\PostCollection;
use Src\Shared\Domain\Objects\Entities\PostEntity;
use Src\Shared\Infrastructure\Models\Post;
use Thehouseofel\Hexagonal\Domain\Exceptions\Database\RecordNotFoundException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;

final class PostRepository implements PostRepositoryContract
{
    private string $model;

    public function __construct()
    {
        $this->model = Post::class;
    }

    public function all(): PostCollection
    {
        $data = $this->model::query()->with('comments')->get();
        return PostCollection::fromArray($data->toArray(), ['comments']);
    }

    public function find(ModelId $id): PostEntity
    {
        try {
            $data = $this->model::query()->with('comments')->findOrFail($id);
            return PostEntity::fromArray($data->toArray(), ['comments']);
        } catch (ModelNotFoundException $e) {
            throw new RecordNotFoundException($e->getMessage());
        }
    }
}
