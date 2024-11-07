<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Category::class);

        $collections = Cache::remember('category_list', 60 * 60, function () {
            return Category::query()->with('image', 'parent')->get();
        });
        // return $collections;
        return view("category.index", compact('collections'));
    }


    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Category::class);
        $category = Cache::remember('category_list', 60 * 60, function () {
            return Category::get();
        });

        return DataTables::of($category)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($category) {
                return '<span class="text-paragraph text-end">' . '#' . $category->id . '</span>';
            })
            ->editColumn('status', function ($category) {
                $status = $category->status == "1" ? 'Active' : 'Inactive';
                $class = $category->status == '1' ? 'bg-resolved-400' : 'bg-closed-400';
                return '<span class="inline-flex px-3 py-1 ' . $class . ' items-center text-paragraph ml-1 rounded">' . $status . '</span>';
            })

            ->editColumn('name', function ($category) {
                $imageUrl = $category->image?->url ?? asset('assets/images/profile.jpg');
                return '
                    <div class="flex items-center" style="width: 200px">
                        <img class="rounded-lg shadow-lg" width="40" height="40" style="border-radius: 50%; border:1px solid #eee" alt="profile" src="' . $imageUrl . '">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . htmlspecialchars($category->name, ENT_QUOTES) . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('parent_id', function ($category) {
                return '
                    <div class="flex items-center" style="width: 200px">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $category->parent ?? 'None' . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('created_at', function ($category) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $category?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($category) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $category->id . ')"
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
                        <div id="action-' . $category->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.category.edit', ['category' => $category->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="#">View</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a href="' . route('admin.category.destroy', ['category' => $category->id]) . '">Delete</a>
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
        Gate::authorize('create', Category::class);
        $parent_categories = Category::query()->get();
        return view('category.create', compact('parent_categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        Gate::authorize('view', $category);
        return view('category.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        Gate::authorize('update', $category);
        $parent_categories = Category::query()->get();
        return view('category.edit', compact('category', 'parent_categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);
    }
}
