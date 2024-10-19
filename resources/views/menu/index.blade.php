<x-app-layout>
    <div class="flex justify-end pb-3">
        <x-actions.href href="{{ route('admin.menu.create') }}">
            Create Menu
        </x-actions.href>
    </div>
    <div class="relative overflow-x-auto bg-white">

        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start pl-3 py-2">Menu Name</th>
                    <th class="text-start pl-3 py-2">Order</th>
                    <th class="text-start pl-3 py-2">Route</th>
                    <th class="text-start pl-3 py-2">Role</th>
                    <th class="text-start pl-3 py-2">Url</th>
                    <th class="text-start pl-3 py-2">Action</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                @forelse ($collections as $each)
                    <tr class="rounded shadow">
                        <td class="p-3 flex">
                            <div class="profile">
                                {!! $each->icon !!}
                            </div>
                            <div class="infos ps-5">
                                <h5 class="font-medium text-slate-900">{{ $each?->name }}</h5>
                            </div>
                        </td>
                        <td class="p-3 font-normal text-gray-400">{{ $each->order }}</td>
                        <td class="p-3 font-normal text-gray-400">{{ $each?->route }}</td>
                        <td class="p-3 font-normal text-gray-400">
                            @foreach (json_decode($each?->roles) as $key => $role)
                                {!! Helper::badge($role) !!}
                            @endforeach
                        </td>
                        <td class="p-3 font-normal text-gray-400">{{ $each?->url }}</td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('admin.menu.edit', ['menu' => $each?->id]) }}" />
                                <x-actions.delete action="{{ route('admin.menu.destroy', ['menu' => $each->id]) }}" />
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
