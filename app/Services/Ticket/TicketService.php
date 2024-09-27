<?php

namespace App\Services\Ticket;

use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        dd($request);

        return $response;
    }

    /**
     * Define public method update to update the resourses
     * @param Model $model
     * @param $request
     * @return array|object|bool
     */
    public function update(Model $model, $request): array | object | bool
    {
        $model->update($request->all());
        return $model;
    }
}
