<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequesterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class RequesterTypeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('view', RequesterType::class);
        $requesterTypes = Cache::remember('requesterType_list', 60 * 60, function () {
            return RequesterType::get();
        });
        return view("requesterType.index", compact('requesterTypes'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('view', RequesterType::class);

        $requesterType = Cache::remember('requesterType_list', 60 * 60, function () {
            return RequesterType::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', RequesterType::class);
        return view('requesterType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', RequesterType::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(RequesterType $requesterType) {
        //
        Gate::authorize('view', $requesterType);
        return view('requesterType.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequesterType $requestertype) {
        Gate::authorize('update', $requestertype);
        return view('requesterType.edit', compact('requestertype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequesterType $requesterType) {
        Gate::authorize('update', $requesterType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequesterType $requesterType) {
        Gate::authorize('delete', $requesterType);
    }
}
