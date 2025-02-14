<?php

declare(strict_types=1);

namespace Src\Admin\Application;

use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;

final readonly class DeleteTagUseCase
{
    public function __construct(
        private TagRepositoryContract $tagRepository,
    )
    {
    }

    public function __invoke(int $id): void
    {
        $this->tagRepository->delete(ModelId::new($id));
    }
}
