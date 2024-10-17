<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Team;
use App\Models\TeamCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', Team::class);
        $collections = Team::query()
            ->with('image', 'agents')
            ->with('teamCategories')
            ->get();
        // return $collections;
        return view("team.index", compact('collections'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('viewAny', Team::class);

        $team = Cache::remember('team_list', 60 * 60, function () {
            return Team::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Team::class);
        $usesCategory = TeamCategory::pluck('category_id');
        $categories   = Category::query()->whereNotIn('id', $usesCategory)->get();
        $agentUser    = User::role('agent')->get();
        return view('team.create', compact('categories', 'agentUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', Team::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team) {
        //
        Gate::authorize('view', $team);
        return view('team.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team) {
        Gate::authorize('update', $team);

        $usesCategory = TeamCategory::where('team_id', '!=', $team->id)->pluck('category_id');
        $categories   = Category::query()->whereNotIn('id', $usesCategory)->get();
        $agentUser    = User::role('agent')->get();
        return view('team.edit', compact('team', 'categories', 'agentUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team) {
        Gate::authorize('update', $team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team) {
        Gate::authorize('delete', $team);
    }
}
