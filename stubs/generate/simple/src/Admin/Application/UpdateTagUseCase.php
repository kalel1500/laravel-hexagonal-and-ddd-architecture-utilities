<?php

declare(strict_types=1);

namespace Src\Admin\Application;

use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Src\Shared\Domain\Objects\Entities\TagEntity;

final readonly class UpdateTagUseCase
{
    public function __construct(
        private TagRepositoryContract $tagRepository,
    )
    {
    }

    public function __invoke(int $id, string $name, string $code, int $type_id): void
    {
        $this->tagRepository->update(TagEntity::fromArray([
            'id'          => $id,
            'name'        => $name,
            'code'        => $code,
            'tag_type_id' => $type_id,
        ]));
    }
}
