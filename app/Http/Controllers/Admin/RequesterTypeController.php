<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\RequesterType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;

class RequesterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', RequesterType::class);
        $requesterTypes = Cache::remember('requesterType_list', 60 * 60, function () {
            return RequesterType::get();
        });
        return view("requestertype.index", compact('requesterTypes'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', RequesterType::class);
        $requesterType = Cache::remember('requesterType_list', 60 * 60, function () {
            return RequesterType::get();
        });

        return DataTables::of($requesterType)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($requesterType) {
                return '<span class="text-paragraph text-end">' . '#' . $requesterType->id . '</span>';
            })
            ->editColumn('status', function ($requesterType) {
                $status = $requesterType->status == "1" ? 'Active' : 'Inactive';
                $class  = $requesterType->status == '1' ? 'bg-resolved-400' : 'bg-closed-400';
                return '<span class="inline-flex px-3 py-1 ' . $class . ' items-center text-paragraph ml-1 rounded">' . $status . '</span>';
            })

            ->editColumn('name', function ($requesterType) {
                return '<h5 class="text-paragraph">' . htmlspecialchars($requesterType->name, ENT_QUOTES) . '</h5>';
            })
            ->editColumn('created_at', function ($requesterType) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $requesterType?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($requesterType) {
                $editUrl = route('admin.requestertype.edit', $requesterType?->id);
                $deleteUrl = route('admin.requestertype.destroy', $requesterType?->id);
                return '
                    <div class="relative">
                        <button onclick="toggleAction(' . $requesterType->id . ')" class="p-3 hover:bg-slate-100 rounded-full">
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
                        <div id="action-' . $requesterType->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC; color:#F36D00">
                                    <a href="' . $editUrl . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                                        ' . csrf_field() . '
                                        ' . method_field("DELETE") . '
                                        <button type="submit" class="text-white">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', RequesterType::class);
        return view('requestertype.create');
    }

    /**
     * Display the specified resource.
     * @param RequesterType $requesterType
     */
    public function show(RequesterType $requesterType)
    {
        Gate::authorize('view', $requesterType);
        return view('requestertype.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param RequesterType $requesterType
     */
    public function edit(RequesterType $requestertype)
    {
        Gate::authorize('update', $requestertype);
        return view('requestertype.edit', compact('requestertype'));
    }

    /**
     * Remove the specified resource from storage.
     * @param RequesterType $requesterType
     */
    public function destroy(RequesterType $requestertype)
    {
        Gate::authorize('delete', RequesterType::class);
        $requestertype->delete();
        Artisan::call('optimize:clear');
        flash()->success('Requester Type has been deleted');
        return back();
    }
}
