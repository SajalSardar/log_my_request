<x-app-layout>
    <div class="flex justify-end pb-3">
        <x-actions.href href="{{ route('admin.team.create') }}">
            Team List
        </x-actions.href>
    </div>
    <div class="relative overflow-x-auto bg-white">

        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start pl-3 py-2">Team Name</th>
                    <th class="text-start pl-3 py-2">Categories</th>
                    <th class="text-start pl-3 py-2">Status</th>
                    <th class="text-start pl-3 py-2">Created Date</th>
                    <th class="text-start pl-3 py-2">Action</th>
                </tr>
            </thead>


            @forelse ($collections as $each)
                <tbody x-data="{ open: false }">
                    <tr class="rounded shadow">
                        <td class="p-3 flex">
                            <div class="mr-2 mt-0.5">
                                <!-- Toggle button -->
                                <span class="cursor-pointer" @click="open = !open">
                                    <template x-if="!open">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 9.75l7.5 7.5 7.5-7.5" />
                                        </svg>
                                    </template>
                                    <template x-if="open">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 14.25l7.5-7.5 7.5 7.5" />
                                        </svg>
                                    </template>
                                </span>
                            </div>
                            <div class="profile">
                                <img src="{{ $each?->image?->url }}" alt="user_picture" height="25" width="25">
                            </div>
                            <div class="infos ps-5 flex">
                                <h5 class="font-medium text-slate-900">{{ $each?->name }}</h5>
                            </div>
                        </td>
                        <td class="p-3 font-normal text-gray-400">
                            @foreach ($each?->teamCategories as $item)
                                {!! Helper::badge($item->name) !!}
                            @endforeach
                        </td>
                        <td class="p-3 font-normal text-gray-400">{!! Helper::status($each?->status) !!} </td>
                        <td class="p-3 font-normal text-gray-400">{{ Helper::ISOdate($each?->created_at) }}</td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('admin.team.edit', $each->id) }}" />
                                <x-actions.delete action="" />
                            </div>
                        </td>
                    </tr>

                    <!-- Hidden content with x-show -->
                    <tr x-show="open" style="display: none;">
                        <td colspan="6" align="center">
                            <table class="my-3" style="width: 95%">
                                <thead class="w-full bg-slate-100">
                                    <tr>
                                        <th class="text-start pl-3 py-2">Name</th>
                                        <th class="text-start pl-3 py-2">Email</th>
                                        <th class="text-start pl-3 py-2">Role</th>
                                        <th class="text-start pl-3 py-2">Phone</th>
                                        <th class="text-start pl-3 py-2">Designation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($each->agents as $agent)
                                        <tr>
                                            <td class="p-3 font-normal text-gray-400">{{ $agent->name }}</td>
                                            <td class="p-3 font-normal text-gray-400">{{ $agent->email }}</td>
                                            <td class="p-3 font-normal text-gray-400">{{ $agent->roles->first()->name }}
                                            </td>
                                            <td class="p-3 font-normal text-gray-400">{{ $agent->phone }}</td>
                                            <td class="p-3 font-normal text-gray-400">{{ $agent->designation }}</td>
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
    </div>
</x-app-layout>
