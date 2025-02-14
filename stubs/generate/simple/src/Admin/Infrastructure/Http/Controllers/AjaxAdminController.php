<?php

declare(strict_types=1);

namespace Src\Admin\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Admin\Application\CreateTagUseCase;
use Src\Admin\Application\DeleteTagUseCase;
use Src\Admin\Application\GetTagListUseCase;
use Src\Admin\Application\UpdateTagUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class AjaxAdminController extends Controller
{
    public function __construct(
        public readonly GetTagListUseCase $getTagsListUseCase,
        public readonly CreateTagUseCase  $createTagUseCase,
        public readonly UpdateTagUseCase  $updateTagUseCase,
        public readonly DeleteTagUseCase  $deleteTagUseCase,
    )
    {
    }

    public function tags(string $type = null): JsonResponse
    {
        $data = $this->getTagsListUseCase->__invoke($type);
        return responseJson(true, 'success', $data->toArray());
    }

    public function create(Request $request): JsonResponse
    {
        $params = $request->validate([
            'name'        => 'required',
            'code'        => 'required',
            'tag_type_id' => 'required',
        ]);
        try {
            $this->createTagUseCase->__invoke($params['name'], $params['code'], $params['tag_type_id']);
            return responseJson(true, __(':Model created successfully', ['Model' => 'Tag']));
        } catch (\Throwable $th) {
            return responseJsonError($th);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $params = $request->validate([
            'name'        => 'required',
            'code'        => 'required',
            'tag_type_id' => 'required',
        ]);
        try {
            $this->updateTagUseCase->__invoke($id, $params['name'], $params['code'], $params['tag_type_id']);
            return responseJson(true, __(':Model updated successfully', ['Model' => 'Tag']));
        } catch (\Throwable $th) {
            return responseJsonError($th);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->deleteTagUseCase->__invoke($id);
            return responseJson(true, __(':Model deleted successfully', ['Model' => 'Tag']));
        } catch (\Throwable $th) {
            return responseJsonError($th);
        }
    }
}
