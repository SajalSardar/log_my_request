<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class MenuController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('view', Menu::class);
        $collections = Menu::query()->get();
        return view('menu.index', compact('collections'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('view', Menu::class);

        $menu = Cache::remember('menu_list', 60 * 60, function () {
            return Menu::get();
        });
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
