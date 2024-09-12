<?php
namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array|object $request): array|object
    {
        $response = Category::create([
            'name'              => $request->name,
            'slug'             => Str::slug($request->name),
            'parent_id'          => $request->parent_id,
            'status'        => $request->status,
        ]);

        return $response;
    }

    /**
     * Define public method update to update the resourses
     * @param Model $model
     * @param $request
     * @return array|object
     */
    public function update(Model $model, $request): array|object
    {
        $model->update($request->all());
        $roleName = Role::query()->where('id', $request->role_id)->first();
        $response = $model->syncRoles($roleName);

        return $response;
    }
}
