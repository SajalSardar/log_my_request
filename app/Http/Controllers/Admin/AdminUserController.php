<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', User::class);
        // $collections = User::query()->with('roles')->whereNotIn('id', [1])->get();
        return view('adminuser.index');
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable(Request $request) {
        Gate::authorize('viewAny', User::class);
        // $User = Cache::remember('name_list', 60 * 60, function () {
        //     return User::get();
        // });

        $users = User::query()->with('roles')->whereNotIn('id', [1]);

        if ($request->all()) {
            $users->where(function ($query) use ($request) {
                if ($request->unser_name_search) {
                    $query->where('name', 'like', '%' . $request->unser_name_search . '%');
                }
                if ($request->unser_email_search) {
                    $query->where('email', '=', $request->unser_email_search);
                }
            });
        }

        return DataTables::of($users)
            ->editColumn('name', function ($users) {
                return '<div class="px-2 flex">
                            <div class="profile">
                                <img src="' . asset('assets/images/user.png') . '" alt="user_picture">
                            </div>
                            <div class="infos ps-5">
                                <h5 class="font-medium text-slate-900">' . $users->name . '</h5>
                            </div></div>';
            })
            ->editColumn('created_at', function ($users) {
                return ISODate($users?->created_at);
            })
            ->addColumn('role', function ($users) {
                return Str::ucfirst($users->roles->first()->name);
            })
            ->addColumn('action_column', function ($users) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $users->id . ')"
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
                        <div id="action-' . $users->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.user.edit', ['user' => $users->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="#">View</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a href="' . route('admin.user.delete', ['user' => $users->id]) . '">Delete</a>
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
     * @return Application|Factory|View
     */
    public function create(): Application | Factory | View {
        Gate::authorize('create', User::class);
        return view('adminuser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', User::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User) {
        //
        Gate::authorize('view', User::class);
        return view('User.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {
        Gate::authorize('update', User::class);
        return view('adminuser.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User) {
        Gate::authorize('update', User::class);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     */
    public function destroy(User $user) {
        Gate::authorize('delete', User::class);
        $user->delete();
        flash()->success('User has been deleted');
        return back();
    }

    public function getUserById(Request $request) {
        return User::where('id', $request->user_id)->first();
    }
}
