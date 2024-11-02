<x-app-layout>
    <div class="flex justify-end pb-3 top-24 right-10">
        <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded block"
            href="{{ route('admin.department.create') }}">
            Create Department
        </a>
    </div>
    <table class="w-full table-fixed">
        <thead class="w-full bg-slate-100 mb-5">
            <tr>
                <th class="text-start ps-10 py-2">Id</th>
                <th class="text-start ps-10 py-2">Name</th>
                <th class="text-start ps-10 py-2">Status</th>
                <th class="text-start ps-10 py-2">Action</th>
            </tr>
        </thead>

        <tbody class="mt-5">
            @forelse ($departments as $department)
                <tr class="rounded shadow">
                    <td class="p-10 font-normal text-gray-400">{{ $department->id }}</td>
                    <td class="p-10 font-normal text-gray-400">{{ $department->name }}</td>
                    <td class="p-10 font-normal text-gray-400">
                        {!! Helper::badge($department->status == 1 ? 'Active' : 'Deactive') !!}
                    </td>
                    <td class="p-10 font-normal text-gray-400">
                        <div class="flex">
                            <a href="{{ route('admin.department.edit', $department->id) }}" class="p-2">
                                <img src="{{ asset('assets/icons/edit.png') }}" alt="edit">
                            </a>
                            <form class="" action="" method="POST">
                                <button type="submit" class="p-2">
                                    <img src="{{ asset('assets/icons/delete.png') }}" alt="__delete">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data not found!</td>
                </tr>
            @endforelse

        </tbody>
    </table>
</x-app-layout>