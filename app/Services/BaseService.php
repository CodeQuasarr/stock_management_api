<?php

namespace App\Services;

use Illuminate\Support\Collection;

abstract class BaseService
{
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
