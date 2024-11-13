<?php

namespace App\Http\Controllers\Admin;

use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', TicketStatus::class);
        $ticketStatuses = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });
        return view("ticketstatus.index", compact('ticketStatuses'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable()
    {
        Gate::authorize('viewAny', TicketStatus::class);
        $ticketStatus = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });

        return DataTables::of($ticketStatus)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($ticketStatus) {
                return '<span class="text-paragraph text-end">' . '#' . $ticketStatus->id . '</span>';
            })
            ->editColumn('status', function ($ticketStatus) {
                $status = $ticketStatus->status == "1" ? 'Active' : 'Inactive';
                $class = $ticketStatus->status == '1' ? 'bg-resolved-400' : 'bg-closed-400';
                return '<span class="inline-flex px-3 py-1 ' . $class . ' items-center text-paragraph ml-1 rounded">' . $status . '</span>';
            })

            ->editColumn('name', function ($ticketStatus) {
                $imageUrl = $ticketStatus->image?->url ?? asset('assets/images/profile.jpg');
                return '
                    <div class="flex items-center" style="width: 200px">
                        <img class="rounded-lg shadow-lg" width="40" height="40" style="border-radius: 50%; border:1px solid #eee" alt="profile" src="' . $imageUrl . '">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . htmlspecialchars($ticketStatus->name, ENT_QUOTES) . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('parent_id', function ($ticketStatus) {
                return '
                    <div class="flex items-center" style="width: 200px">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $ticketStatus->parent ?? 'None' . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('created_at', function ($ticketStatus) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $ticketStatus?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($ticketStatus) {
                $editUrl = route('admin.ticketstatus.edit', $ticketStatus?->id);
                $deleteUrl = route('admin.ticketstatus.delete', $ticketStatus?->id);
                return '
                    <div class="relative">
                        <button onclick="toggleAction(' . $ticketStatus->id . ')" class="p-3 hover:bg-slate-100 rounded-full">
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
                        <div id="action-' . $ticketStatus->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
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
        Gate::authorize('create', TicketStatus::class);
        return view('ticketstatus.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketStatus $ticketstatus)
    {
        //
        Gate::authorize('view', $ticketstatus);
        return view('ticketstatus.show', compact('ticketstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketStatus $ticketstatus)
    {
        Gate::authorize('update', $ticketstatus);
        return view('ticketstatus.edit', compact('ticketstatus'));
    }

    /**
     * Remove the specified resource from storage.
     * @param TicketStatus $ticketStatus
     */
    public function destroy(TicketStatus $ticketstatus)
    {
        Gate::authorize('delete', TicketStatus::class);
        $ticketstatus->delete();
        Artisan::call('optimize:clear');
        flash()->success('Status has been deleted');
        return back();
    }
}
