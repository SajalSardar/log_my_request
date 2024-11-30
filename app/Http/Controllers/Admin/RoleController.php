<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller {

    public function index() {
        Gate::authorize('viewAny', Role::class);

        $roles = Role::with('permissions')->orderBy('id', 'desc')->get();
        return view('role.index', compact('roles'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request) {

        Gate::authorize('viewAny', Role::class);
        $roles = Role::with('permissions')->whereNotIn('name', ['super-admin'])->orderBy('id', 'desc')->get();

        return DataTables::of($roles)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($roles) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . '#' . $roles->id . '</span></div>';
            })
            ->editColumn('name', function ($roles) {
                return '
                    <div class="flex items-center">
                            <img src="' . asset('assets/images/profile.jpg') . '" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $roles->name . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('permission', function ($roles) {
                $permissionsHtml = '';
                foreach ($roles->permissions as $key => $permission) {
                    if ($key > 5) {
                        $permissionsHtml .= '<a href="' . route('admin.role.edit', ['id' => $roles->id]) . '" class="underline ml-2 text-green-500">more..</a>';
                        break;
                    }
                    $permissionsHtml .= '<span class="inline-flex px-3 py-1 bg-inProgress-400 items-center text-paragraph ml-1 rounded">' . $permission->name . '</span>';;
                }

                return $permissionsHtml;
            })
            ->editColumn('created_at', function ($roles) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $roles?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($roles) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $roles->id . ')"
                            class="p-3 hover:bg-slate-100 rounded-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div id="action-' . $roles->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.role.edit', ['id' => $roles->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="#">View</a>
                                </li>
                            </ul>
                        </div></div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function create() {
        Gate::authorize('create', Role::class);
        $user  = User::where('id', Auth::id())->first();
        $query = Module::query()->with('permissions');
        if (!$user->hasRole('super-admin')) {
            $query->whereNotIn('name', ['menu', 'module']);

        }
        $modules = $query->get();
        return view('role.create', compact('modules'));
    }

    public function store(Request $request) {
        Gate::authorize('create', Role::class);

        $request->validate([
            'role' => 'required|unique:roles,name',
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

        $role  = Role::with('permissions')->find($id);
        $user  = User::where('id', Auth::id())->first();
        $query = Module::query()->with('permissions');
        if (!$user->hasRole('super-admin')) {
            $query->whereNotIn('name', ['menu', 'module']);

        }
        $modules = $query->get();

        if ($role->id) {
            $rolePermmission = @$role->permissions->pluck("id")->toArray();
        } else {
            $rolePermmission = [];
        }
        return view('role.edit', compact('modules', 'role', 'rolePermmission'));
    }

    /**
     * Define method for update the resources
     * @param Request $request
     * @param ?string $id
     */
    public function update(Request $request, $id) {
        Gate::authorize('update', Role::class);

        $request->validate([
            'role' => 'required|unique:roles,name,' . $id,
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
