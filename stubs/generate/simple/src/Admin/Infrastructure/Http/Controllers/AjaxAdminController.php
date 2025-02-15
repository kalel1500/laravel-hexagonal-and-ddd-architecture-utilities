<?php

declare(strict_types=1);

namespace Src\Admin\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Admin\Application\UpdateOrCreateTagUseCase;
use Src\Admin\Application\DeleteTagUseCase;
use Src\Admin\Application\GetTagListUseCase;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;

final class AjaxAdminController extends Controller
{
    public function __construct(
        public readonly GetTagListUseCase        $getTagsListUseCase,
        public readonly UpdateOrCreateTagUseCase $updateOrCreateTagUseCase,
        public readonly DeleteTagUseCase         $deleteTagUseCase,
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
            $this->updateOrCreateTagUseCase->__invoke($params);
            return responseJson(true, __('h::database.model_created_successfully', ['model' => 'Tag']));
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
        $params = ['id' => $id, ...$params];

        try {
            $this->updateOrCreateTagUseCase->__invoke($params);
            return responseJson(true, __('h::database.model_updated_successfully', ['model' => 'Tag']));
        } catch (\Throwable $th) {
            return responseJsonError($th);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->deleteTagUseCase->__invoke($id);
            return responseJson(true, __('h::database.model_deleted_successfully', ['model' => 'Tag']));
        } catch (\Throwable $th) {
            return responseJsonError($th);
        }
    }
}
