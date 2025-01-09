<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface ServiceInterface
{

    public static function new();

    public function store(Collection $data): array;

    public function update(Collection $data, $id, Model $model = null):array;

    public function attach(Collection $data, Model $model, $relation = null): array;

    public function delete(int $id): array;


}
