<?php

declare(strict_types=1);

namespace Src\Admin\Application;

use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Src\Shared\Domain\Objects\Entities\Collections\TagCollection;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

final readonly class GetTagListUseCase
{
    public function __construct(
        private TagRepositoryContract $tagRepository,
    )
    {
    }

    public function __invoke(string $type = null): TagCollection
    {
        return $this->tagRepository->searchByType(ModelStringNull::new($type));
    }
}
