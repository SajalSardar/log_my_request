<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
     */
    public function displayListDatatable(Request $request) {
        Gate::authorize('viewAny', Menu::class);

        // $menu = Cache::remember('menu_list', 60 * 60, function () {
        //     return Menu::get();
        // });
        $menus = Menu::query();

        if ($request->all()) {
            $menus->where(function ($query) use ($request) {
                if ($request->unser_name_search) {
                    $query->where('name', 'like', '%' . $request->unser_name_search . '%');
                }
            });
        }

        return DataTables::of($menus)
            ->editColumn('name', function ($menus) {
                return '<div class="flex"><div class="profile">
                                ' . $menus->icon . '
                            </div>
                            <div class="infos ps-3">
                                <h5 class="font-medium text-slate-900">' . $menus->name . '</h5>
                            </div></div>';
            })
            ->editColumn('created_at', function ($menus) {
                return ISODate($menus?->created_at);
            })
            ->addColumn('role', function ($menus) {
                $rolesHtml = '';
                $roles     = json_decode($menus->roles, true);
                foreach ($roles as $role) {
                    $rolesHtml .= '<span class="inline-flex items-center bg-green-100 text-gray-800 text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">' . $role . '</span>';
                }
                return $rolesHtml;
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
        return view('menu.create', compact('roles', 'parent_menus'));
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
        return view('menu.edit', compact('roles', 'parent_menus', 'menu'));
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
