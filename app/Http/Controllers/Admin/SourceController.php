<?php

namespace App\Http\Controllers\Admin;

use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Source::class);
        $sources = Cache::remember('source_list', 60 * 60, function () {
            return Source::get();
        });

        return view("source.index", compact('sources'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Source::class);

        $source = Cache::remember('source_list', 60 * 60, function () {
            return Source::get();
        });

        return DataTables::of($source)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($source) {
                return '<span class="text-paragraph text-end">' . '#' . $source->id . '</span>';
            })
            ->editColumn('status', function ($source) {
                $status = $source->status == "1" ? 'Active' : 'Inactive';
                $class = $source->status == '1' ? 'bg-inProgress-400' : 'bg-open-400';
                return '<span class="inline-flex px-3 py-1 ' . $class . ' items-center text-paragraph ml-1 rounded">' . $status . '</span>';
            })

            ->editColumn('title', function ($source) {
                $imageUrl = $source->image?->url ?? asset('assets/images/profile.jpg');
                return '<h5 class="text-paragraph">' . htmlspecialchars($source->title, ENT_QUOTES) . '</h5>';
            })
            ->editColumn('created_at', function ($source) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $source?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($source) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $source->id . ')"
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
                        <div id="action-' . $source->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.source.edit', ['source' => $source->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="#">View</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a href="' . route('admin.source.destroy', ['source' => $source->id]) . '">Delete</a>
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
     */
    public function create()
    {
        Gate::authorize('create', Source::class);
        return view('source.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
        Gate::authorize('view', $source);
        return view('source.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        Gate::authorize('update', $source);

        return view('source.edit', compact('source'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        Gate::authorize('delete', $source);
    }
}
