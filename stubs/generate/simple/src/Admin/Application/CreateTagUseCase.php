<?php

declare(strict_types=1);

namespace Src\Admin\Application;

use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Src\Shared\Domain\Objects\Entities\TagEntity;

final readonly class CreateTagUseCase
{
    public function __construct(
        private TagRepositoryContract $tagRepository,
    )
    {
    }

    public function __invoke(string $name, string $code, int $type_id): void
    {
        $this->tagRepository->create(TagEntity::fromArray([
            'name'        => $name,
            'code'        => $code,
            'tag_type_id' => $type_id,
        ]));
    }
}
