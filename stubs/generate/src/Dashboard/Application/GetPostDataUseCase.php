<?php

declare(strict_types=1);

namespace Src\Dashboard\Application;

use Src\Shared\Domain\Contracts\Repositories\PostRepositoryContract;
use Src\Shared\Domain\Objects\Entities\PostEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

final readonly class GetPostDataUseCase
{
    public function __construct(
        public PostRepositoryContract $repositoryPost,
    )
    {
    }

    public function __invoke(string $slug): PostEntity
    {
        return $this->repositoryPost->findBySlug(ModelString::new($slug));
    }
}
