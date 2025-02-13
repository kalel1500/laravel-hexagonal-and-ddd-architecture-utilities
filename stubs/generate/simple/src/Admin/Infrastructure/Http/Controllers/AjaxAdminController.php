<?php

declare(strict_types=1);

namespace Src\Admin\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Admin\Application\GetTagListUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class AjaxAdminController extends Controller
{
    public function __construct(
        public readonly GetTagListUseCase $getTagsListUseCase,
    )
    {
    }

    public function tags(string $type = null): JsonResponse
    {
        $data = $this->getTagsListUseCase->__invoke($type);
        return responseJson(true, 'success', $data->toArray());
    }
}
