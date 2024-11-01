<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', Department::class);
        $departments = Department::get();
        return view("department.index", compact('departments'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('viewAny', Department::class);

        $department = Cache::remember('department_list', 60 * 60, function () {
            return Department::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Department::class);
        return view('department.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department) {
        //
        Gate::authorize('view', $department);
        return view('department.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department) {
        Gate::authorize('update', $department);
        return view('department.edit', compact('department'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department) {
        Gate::authorize('delete', $department);
    }
}
