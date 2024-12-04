<x-app-layout>
    @section('title', 'Team List')
    @include('team.breadcrumb.index')
    <div class="flex justify-between items-center !mt-3 mb-6">
        <div>
            <p class="text-detail-heading">Team List</p>
        </div>
        <div class="flex-1 mt-1">
            <div class="flex justify-end gap-3">
                @can('department create')
                <div>
                    <x-actions.href href="{{ route('admin.team.create') }}" class="block">
                        Create Team
                        <svg class="inline-block" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 8V16M16.5 12H8.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z" stroke="white" stroke-width="1.5" />
                        </svg>
                    </x-actions.href>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
            <thead style="background:#F3F4F6; border:none">
                <tr>
                    <th class="text-heading-dark pl-5 text-start">Team Name</th>
                    <th class="text-heading-dark text-start">Department</th>
                    <th class="text-heading-dark text-start">Categories</th>
                    <th class="text-heading-dark text-start">Status</th>
                    <th class="text-heading-dark text-start">Created</th>
                    <th class="text-heading-dark text-start"></th>
                </tr>
            </thead>

            @forelse ($collections as $each)
            <tbody x-data="{ open: false }">
                <tr class="text-center border border-base-500">
                    <td>
                        <div class="flex pl-2">
                            <div>
                                <span class="cursor-pointer" @click="open = !open">
                                    <template x-if="!open">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 18L15 12L9 6" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </template>
                                    <template x-if="open">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 9L12 15L18 9" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </template>
                                </span>
                            </div>
                            <div class="profile">
                                @if (!empty($each->image) && !empty($each->image->url))
                                <img src="{{ $each->image->url }}" alt="user_picture" height="25" width="25">
                                @else
                                {!! avatar($each->name) !!}
                                @endif
                            </div>
                            <div class="infos ps-5 flex">
                                <h5 class="text-paragraph">{{ $each?->name }}</h5>
                            </div>
                        </div>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-2">{{ $each->department->name }}</span>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-3">
                            @foreach ($each?->teamCategories as $item)
                            {!! Helper::badge($item->name) !!}
                            @endforeach
                        </span>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-3">
                            {!! Helper::status($each?->status) !!}
                        </span>
                    </td>
                    <td class="text-paragraph">
                        <p class="-ml-2">
                            {{ Helper::ISOdate($each?->created_at) }}
                        </p>
                    </td>
                    <td>
                        <div class="relative">
                            <button onclick="toggleAction({{$each->id}})" class="p-3 hover:bg-slate-100 rounded-full">
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
                            <div id="action-{{ $each->id }}" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                                <ul>
                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                        <a href="{{ route('admin.team.edit',['team' => $each->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                        <form action="{{ route('admin.team.destroy',['team' => $each->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-paragraph">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr x-show="open" style="display: none;">
                    <td colspan="6">
                        <table class="w-full child-table" style="table-layout: auto;">
                            <thead class="w-full">
                                <tr style="border-bottom:1px solid #ddd">
                                    <th class="text-heading-dark text-start pl-3">Name</th>
                                    <th class="text-heading-dark text-start">Email</th>
                                    <th class="text-heading-dark text-start">Role</th>
                                    <th class="text-heading-dark text-start">Phone</th>
                                    <th class="text-heading-dark text-start">Designation</th>
                                    <th class="text-heading-dark text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody class="w-full">
                                @foreach ($each->agents as $agent)
                                <tr style="border-bottom:1px solid #ddd">
                                    <td class="text-paragraph">
                                        <span class="-ml-2 pl-3">
                                            {{ $agent->name }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->email }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->roles->first()->name }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->phone }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->designation }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="relative">
                                            <button onclick="toggleAction({{$agent->id}})" class="p-3 hover:bg-slate-100 rounded-full">
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
                                            <div id="action-{{ $agent->id }}" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                                                <ul>
                                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                                        <a href="' . $editUrl . '">Edit</a>
                                                    </li>
                                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                                        <form>
                                                            <button type="submit" class="text-paragraph">Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            @empty
            <tbody>
                <tr>
                    <td colspan="6" class="text-center">
                        <h5 class="font-medium text-slate-900">No data found !!!</h5>
                    </td>
                </tr>
            </tbody>
            @endforelse

        </table>
        <div class="mt-3">
            {{ $collections->links() }}
        </div>
    </div>
</x-app-layout>