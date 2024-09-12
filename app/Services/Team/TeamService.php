<?php

namespace App\Services\Team;

use App\Models\Team;
use App\Models\Category;
use App\Models\TeamCategory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class TeamService
{
    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array|object $request): array|object
    {
        $team = Team::create([
            'name'              => $request->name,
            'slug'             => Str::slug($request->name),
            'status'        => $request->status,
        ]);

        $teamCategories = [];

        foreach ($request->category_id as $category) {
            $teamCategories[] = [
                'category_id' => $category,
                'team_id'     => $team->getKey(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }
        if ($team) {
            TeamCategory::insert($teamCategories);
            return $team;
        } else {
            return false;
        }
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
