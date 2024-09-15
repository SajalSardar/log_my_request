<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ModuleController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('view', Module::class);

        $modules = Module::all();
        return view('module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Module::class);
        return view('module.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        Gate::authorize('create', Module::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module) {
        Gate::authorize('view', $module);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module) {
        Gate::authorize('update', $module);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module) {
        Gate::authorize('update', $module);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module) {
        Gate::authorize('delete', $module);
    }
}
