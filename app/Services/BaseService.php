<?php

namespace App\Services;

use App\Responses\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

abstract class BaseService implements ServiceInterface
{
    public function __construct(private readonly mixed $model = null)
    {
    }

    /**
     * @param Collection $data
     * @return JsonResponse
     */
    public function store(Collection $data): JsonResponse
    {
        $success = false;
        $msg = null;
        $id = null;
        if ($success) {
            $msg = "Le model a été créé.";
        } else {
            $msg = "Le model n'a pas été créé.";
        }
        return ApiResponse::sendResponse($data, $msg);
    }

    /**
     * @param Collection $data
     * @param            $id
     * @param Model|null $model
     * @return array
     */
    public function update(Collection $data, $id, Model $model = null): array
    {
        $success = false;
        $msg = null;
        if ($success) {
            $msg = "Le model a été mis à jour";
        } else {
            $msg = "Le model n'a pas été mis à jour";
        }
        return ApiResponse::sendResponse($data, $msg);
    }

    /**
     * Reduce fields to those of the model
     *
     * @param $model
     * @param Collection $requestField
     * @return Collection
     */
    protected function getModelFields( Collection $requestField, $model): Collection {
        $modelFields = $model->getFillable();
        $fields = collect();
        foreach ($modelFields as $oneKey) {
            if ($requestField->has($oneKey)) $fields->put($oneKey, $requestField->get($oneKey));
        }
        return $fields;
    }
}
