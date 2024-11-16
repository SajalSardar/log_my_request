<x-app-layout>
    @section('title', 'Team List')
    @section('breadcrumb')
    <x-breadcrumb>
        Team List
    </x-breadcrumb>
    @endsection

    <div class="flex justify-end pb-4">
        <x-actions.href href="{{ route('admin.team.create') }}">
            Create Team
        </x-actions.href>
    </div>

    <div class="relative">
        <table class="display nowrap parent-table" id="data-table" style="width: 100%;border:1px solid #ddd;table-layout:auto">
            <thead style="background:#F3F4F6;">
                <tr>
                    <th class="text-heading-dark pl-5 text-start">Team Name</th>
                    <th class="text-heading-dark text-start">Department</th>
                    <th class="text-heading-dark text-start">Categories</th>
                    <th class="text-heading-dark text-start">Status</th>
                    <th class="text-heading-dark text-start">Created</th>
                    <th class="text-heading-dark text-start">Action</th>
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
                                <img class="rounded-lg shadow-lg" width="30" height="30" style="border-radius: 50%; border:1px solid #eee" alt="profile" src="https://placehold.co/50">
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
                                    <li class="px-5 py-1 text-center" style="background: #FFF4EC; color:#F36D00">
                                        <a href="{{ route('admin.team.edit',['team' => $each->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-red-600 text-white">
                                        <form action="{{ route('admin.team.destroy',['team' => $each->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white">Delete</button>
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
                                                    <li class="px-5 py-1 text-center" style="background: #FFF4EC; color:#F36D00">
                                                        <a href="' . $editUrl . '">Edit</a>
                                                    </li>
                                                    <li class="px-5 py-1 text-center bg-red-600 text-white">
                                                        <form>
                                                            <button type="submit" class="text-white">Delete</button>
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