<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view',  Source::class);
        return view("source.index");
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('view',  Source::class);
        
        $source = Cache::remember('source_list', 60 * 60, function () {
            return Source::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Source::class);
        return view('source.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', Source::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
        Gate::authorize('view',  $source);
        return view('source.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        Gate::authorize('update', $source);
        return view('source.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        Gate::authorize('update',  $source);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        Gate::authorize('delete',  $source);
    }
}
