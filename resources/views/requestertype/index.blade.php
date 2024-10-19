<x-app-layout>
    <div class="flex justify-end pb-3">
        <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded"
            href="{{ route('admin.requestertype.create') }}">
            Create Type
        </a>
    </div>
    <table class="w-full table-fixed">
        <thead class="w-full bg-slate-100 mb-5">
            <tr>
                <th class="text-start pl-3 py-2">Id</th>
                <th class="text-start pl-3 py-2">Name</th>
                <th class="text-start pl-3 py-2">Status</th>
                <th class="text-start pl-3 py-2">Action</th>
            </tr>
        </thead>

        <tbody class="mt-5">
            @forelse ($requesterTypes as $type)
                <tr class="rounded shadow">

                    <td class="p-3 font-normal text-gray-400">{{ $type->id }}</td>
                    <td class="p-3 font-normal text-gray-400">{{ $type->name }}</td>
                    <td class="p-3 font-normal text-gray-400">{{ $type->status }}</td>
                    <td class="p-3 font-normal text-gray-400">
                        <div class="flex">
                            <a href="{{ route('admin.requestertype.edit', $type->id) }}" class="p-2">
                                <img src="{{ asset('assets/icons/edit.png') }}" alt="edit">
                            </a>
                            <form class="" action="" method="POST">
                                <button type="submit" class="p-2">
                                    <img src="{{ asset('assets/icons/delete.png') }}" alt="delete">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
            @endforelse

        </tbody>
    </table>
</x-app-layout>
