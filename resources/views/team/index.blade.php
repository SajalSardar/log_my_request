<x-app-layout>
    <div class="flex justify-end pb-3">
        <x-actions.href href="{{ route('admin.team.create') }}">
            Create Team
        </x-actions.href>
    </div>
    <div class="relative overflow-x-auto bg-white">

        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start pl-3 py-2">Team Name</th>
                    <th class="text-start pl-3 py-2">Categories</th>
                    <th class="text-start pl-3 py-2">Agents</th>
                    <th class="text-start pl-3 py-2">Status</th>
                    <th class="text-start pl-3 py-2">Mofified at</th>
                    <th class="text-start pl-3 py-2">Action</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                @forelse ($collections as $each)
                    <tr class="rounded shadow">
                        <td class="p-3 flex">
                            <div class="profile">
                                <img src="{{ $each?->image?->url }}" alt="user_picture">
                            </div>
                            <div class="infos ps-5">
                                <h5 class="font-medium text-slate-900">{{ $each?->name }}</h5>
                            </div>
                        </td>
                        <td class="p-3 font-normal text-gray-400">
                            @foreach ($each?->teamCategories as $item)
                                {!! Helper::badge($item->name) !!}
                            @endforeach
                        </td>
                        <td class="p-3 font-normal text-gray-400">
                            @foreach ($each?->agents as $item)
                                {!! Helper::badge($item->name) !!}
                            @endforeach
                        </td>
                        <td class="p-3 font-normal text-gray-400">{!! Helper::status($each?->status) !!} </td>
                        <td class="p-3 font-normal text-gray-400">{{ Helper::ISOdate($each?->updated_at) }}</td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('admin.team.edit', $each->id) }}" />
                                <x-actions.delete action="" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <h5 class="font-medium text-slate-900">No data found !!!</h5>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</x-app-layout>
