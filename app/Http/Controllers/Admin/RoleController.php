<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    public function index() {
        Gate::authorize('view', Role::class);

        $roles = Role::orderBy('id', 'desc')->get();
        return view('role.index', compact('roles'));
    }

    public function create() {
        Gate::authorize('create', Role::class);

        $modules = Module::with('permissions')->get();
        return view('role.create', compact('modules'));
    }

    public function store(Request $request) {
        Gate::authorize('create', Role::class);

        $request->validate([
            'role' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->role,
        ]);
        $role->givePermissionTo($request->permission);

        flash()->success('Role Created Successfully!');
        return back();
    }

    /**
     * Define public method edit()
     * @param $id;
     */
    public function edit($id) {
        Gate::authorize('update', Role::class);

        $role    = Role::with('permissions')->find($id);
        $modules = Module::with('permissions')->get();
        if ($role->id) {
            $rolePermmission = @$role->permissions->pluck("id")->toArray();
        } else {
            $rolePermmission = [];
        }
        return view('role.edit', compact('modules', 'role', 'rolePermmission'));
    }

    public function update(Request $request, $id) {
        Gate::authorize('update', Role::class);

        $request->validate([
            'role' => 'required',
        ]);
        $role = Role::with('permissions')->find($id);
        $role->update([
            'name' => $request->role,
        ]);

        $role->syncPermissions($request->permission);

        flash()->success('Role Update Successfully!');
        return back();
    }

    public function switchAccount(Request $request) {

        $request->session()->put('login_role', $request->role);
        return back();
    }
}
