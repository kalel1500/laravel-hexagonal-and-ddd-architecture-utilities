<?php

declare(strict_types=1);

namespace Src\Dashboard\Application;

use Src\Dashboard\Domain\Objects\DataObjects\DashboardDataDto;
use Src\Shared\Domain\Contracts\Repositories\PostRepositoryContract;
use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

final readonly class GetDashboardDataUseCase
{
    public function __construct(
        public PostRepositoryContract $repositoryPost,
        public TagRepositoryContract  $repositoryTag,
    )
    {
    }

    public function __invoke(?string $tag): DashboardDataDto
    {
        $tags  = $this->repositoryTag->all();
        $posts = $this->repositoryPost->searchByTag(ModelStringNull::new($tag));
        return DashboardDataDto::fromArray([
            $tags,
            $posts,
            $posts->count(),
            $tag,
        ]);
    }
}
