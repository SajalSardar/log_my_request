<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('view', Category::class);

        $collections = Cache::remember('category_list', 60 * 60, function () {
            return Category::query()->with('image')->get();
        });
        return view("category.index", compact('collections'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('view', Category::class);

        $category = Cache::remember('category_list', 60 * 60, function () {
            return Category::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Category::class);
        $parent_categories = Category::query()->get();
        return view('category.create', compact('parent_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', Category::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) {
        //
        Gate::authorize('view', $category);
        return view('category.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) {
        Gate::authorize('update', $category);
        $parent_categories = Category::query()->get();
        return view('category.edit', compact('category', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category) {
        Gate::authorize('update', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category) {
        Gate::authorize('delete', $category);
    }
}
