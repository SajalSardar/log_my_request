<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('role.index', compact('roles'));
    }

    public function create()
    {
        $modules = Module::with('permissions')->get();
        return view('role.create', compact('modules'));
    }

    public function store(Request $request)
    {
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
    public function edit($id)
    {
        $role    = Role::with('permissions')->find($id);
        $modules = Module::with('permissions')->get();
        if ($role->id) {
            $rolePermmission = @$role->permissions->pluck("id")->toArray();
        } else {
            $rolePermmission = [];
        }
        return view('role.edit', compact('modules', 'role', 'rolePermmission'));
    }

    public function update(Request $request, $id)
    {

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

    public function switchAccount(Request $request)
    {

        $request->session()->put('login_role', $request->role);
        return back();
    }
}
