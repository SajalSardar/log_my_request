<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view',  Team::class);
        return view("team.index");
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('view',  Team::class);

        $team = Cache::remember('name_list', 60 * 60, function () {
            return Team::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Team::class);
        $categories = Category::query()->get();
        return view('team.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', Team::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
        Gate::authorize('view',  $team);
        return view('team.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        Gate::authorize('update', $team);
        return view('team.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        Gate::authorize('update',  $team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        Gate::authorize('delete',  $team);
    }
}
