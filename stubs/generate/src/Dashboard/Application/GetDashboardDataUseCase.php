<?php

declare(strict_types=1);

namespace Src\Dashboard\Application;

use Src\Dashboard\Domain\Objects\DataObjects\DashboardDataDto;
use Src\Shared\Domain\Contracts\Repositories\PostRepositoryContract;
use Src\Shared\Domain\Contracts\Repositories\TagRepositoryContract;

final readonly class GetDashboardDataUseCase
{
    public function __construct(
        public PostRepositoryContract $repositoryPost,
        public TagRepositoryContract  $repositoryTag,
    )
    {
    }

    public function __invoke(): DashboardDataDto
    {
        $tags = $this->repositoryTag->all();
        $posts = $this->repositoryPost->all();
        return DashboardDataDto::fromArray([
            'tags' => $tags,
            'posts' => $posts,
        ]);
    }
}
