<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', Menu::class);
        return view('menu.index');
    }

    /**
     * Display a listing of the data table resource.
     * @param Request $request
     */
    public function displayListDatatable(Request $request) {
        Gate::authorize('viewAny', Menu::class);
        $menus = Menu::query();

        if ($request->all()) {
            $menus->where(function ($query) use ($request) {
                if ($request->unser_name_search) {
                    $query->where('name', 'like', '%' . $request->unser_name_search . '%');
                }
            });
        }

        return DataTables::of($menus)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($menus) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . '#' . $menus->id . '</span></div>';
            })
            ->editColumn('order', function ($menus) {
                return '<span class="text-paragraph text-end">' . $menus->order . '</span>';
            })
            ->editColumn('route', function ($menus) {
                return '<span class="text-paragraph text-end">' . $menus->route . '</span>';
            })
            ->editColumn('url', function ($menus) {
                return '<span class="text-paragraph text-end">' . $menus->url . '</span>';
            })
            ->editColumn('name', function ($menus) {
                return '<div class="flex gap-2">
                            <div>
                                ' . $menus->icon . '
                            </div>
                            <h5 class="text-paragraph">' . $menus->name . '</h5>
                        </div>';
            })
            ->editColumn('created_at', function ($menus) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $menus?->created_at) . '</span>';
            })
            ->addColumn('role', function ($menus) {
                $rolesHtml = '';
                $roles     = json_decode($menus->roles, true);
                foreach ($roles as $role) {
                    $rolesHtml .= '<span class="inline-flex px-3 py-1 bg-inProgress-400 items-center text-paragraph ml-1 rounded">' . $role . '</span>';
                }
                return $rolesHtml;
            })
            ->addColumn('permission', function ($menus) {
                $permissionsHtml = '';
                $permissions     = $menus->permissions ? json_decode($menus->permissions, true) : [];
                foreach ($permissions as $permission) {
                    $permissionsHtml .= '<span class="inline-flex px-3 py-1 bg-gray-400 items-center text-paragraph ml-1 rounded">' . $permission . '</span>';
                }
                return $permissionsHtml;
            })
            ->addColumn('action_column', function ($menus) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $menus->id . ')"
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
                        <div id="action-' . $menus->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.menu.edit', $menus->id) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a
                                        href="' . route('admin.menu.destroy', $menus->id) . '">Delete</a>
                                </li>
                            </ul>
                        </div></div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Menu::class);
        $roles        = Role::where('name', '!=', 'super-admin')->get();
        $parent_menus = Menu::where('parent_id', null)->get();
        $routes       = collect(Route::getRoutes())->map(function ($route) {
            return $route->getName();
        })->push('#');
        $permission_list = Permission::get();
        return view('menu.create', compact('routes', 'roles', 'parent_menus', 'permission_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', Menu::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu) {
        //
        Gate::authorize('view', $menu);
        return view('menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu) {
        Gate::authorize('update', $menu);
        $roles        = Role::where('name', '!=', 'super-admin')->get();
        $parent_menus = Menu::where('parent_id', null)->get();
        $routes       = collect(Route::getRoutes())->map(function ($route) {
            return $route->getName();
        })->push('#');
        $permission_list = Permission::get();
        return view('menu.edit', compact('roles', 'parent_menus', 'menu', 'routes', 'permission_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu) {
        Gate::authorize('update', $menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu) {
        Gate::authorize('delete', $menu);
        $menu->delete();
        flash()->success('Menu has been deleted');
        return back();
    }
}
