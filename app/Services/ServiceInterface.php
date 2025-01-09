<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface ServiceInterface
{

    public static function new();

    public function store(Collection $data): JsonResponse;

    public function update(Collection $data, $id, Model $model = null);

    public function attach(Collection $data, Model $model, $relation = null): JsonResponse;

    public function delete(int $id);


}
