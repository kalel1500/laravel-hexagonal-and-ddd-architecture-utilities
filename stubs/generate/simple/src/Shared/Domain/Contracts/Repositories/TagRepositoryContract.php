<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Contracts\Repositories;

use Src\Shared\Domain\Objects\Entities\Collections\TagCollection;
use Src\Shared\Domain\Objects\Entities\TagEntity;

interface TagRepositoryContract
{
    public function all(): TagCollection;
    public function create(TagEntity $tag): void;
    public function update(TagEntity $tag): void;
}
