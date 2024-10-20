<x-app-layout>
    <div class="flex justify-end pb-3">
        <x-actions.href href="{{ route('admin.user.create') }}">
            Create User
        </x-actions.href>
    </div>
    <div class="relative overflow-x-auto bg-white">

        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start pl-3 py-2">User Name</th>
                    <th class="text-start pl-3 py-2">Email</th>
                    <th class="text-start pl-3 py-2">Email Verified</th>
                    <th class="text-start pl-3 py-2">Roles</th>
                    <th class="text-start pl-3 py-2">Action</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                @forelse ($collections as $each)
                    <tr class="rounded shadow">
                        <td class="p-3 flex">
                            <div class="profile">
                                <img src="{{ asset('assets/images/user.png') }}" alt="user_picture">
                            </div>
                            <div class="infos ps-5">
                                <h5 class="font-medium text-slate-900">{{ $each?->name }}</h5>
                            </div>
                        </td>
                        <td class="p-3 font-normal text-gray-400">{{ $each?->email }}</td>
                        <td class="p-3 font-normal text-gray-400">{{ Helper::ISOdate($each?->email_verified_at) }}</td>
                        <td class="p-3 font-normal text-gray-400">
                            {{ Str::ucfirst($each->roles->first()->name) }}
                        </td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('admin.user.edit', ['user' => $each?->id]) }}" />
                                <x-actions.delete action="{{ route('admin.user.delete', ['user' => $each?->id]) }}" />
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
