<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Livewire\AdminUser\UpdateAdminUser;
use App\Livewire\Forms\AdminUserUpdateRequest;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view',  User::class);
        $collections = User::query()->with('roles')->whereNotIn('id', [1])->get();
        return view('adminuser.index', compact('collections'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('view',  User::class);
        $User = Cache::remember('name_list', 60 * 60, function () {
            return User::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     * @return Application|Factory|View
     */
    public function create(): Application |Factory|View
    {
        Gate::authorize('create', User::class);
        return view('adminuser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', User::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
        Gate::authorize('view',  User::class);
        return view('User.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', User::class);
        return view('adminuser.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User)
    {
        Gate::authorize('update',  User::class);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete',  User::class);
        $user->delete();
        flash()->success('User has been deleted');
        return back();
    }
}
