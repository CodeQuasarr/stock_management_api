<?php

namespace App\Services;

use App\Responses\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

abstract class BaseService implements ServiceInterface
{
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
     * @return JsonResponse
     */
    public function update(Collection $data, $id, Model $model = null): JsonResponse
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
}
