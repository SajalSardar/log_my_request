<x-app-layout>
    <div class="relative overflow-x-auto bg-white">
        <div class="flex justify-end pb-3 fixed top-24 right-10">
            <x-actions.href href="{{ route('dashboard.module.create') }}">
                Create Module
            </x-actions.href>
        </div>
        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start ps-10 py-2">Name</th>
                    <th class="text-start ps-10 py-2">Slug</th>
                    <th class="text-start ps-10 py-2">Permission</th>
                    <th class="text-start ps-10 py-2">View</th>
                    <th class="text-start ps-10 py-2">Livewire <br> Component</th>
                    <th class="text-start ps-10 py-2">Model <br> Controller <br> Policy</th>
                    <th class="text-start ps-10 py-2">Action</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                @forelse ($modules as $item)
                    <tr class="rounded shadow">

                        <td class="p-10 font-normal text-gray-400">{{ $item->name }}</td>
                        <td class="p-10 font-normal text-gray-400">{{ $item->slug }}</td>
                        <td class="p-10 font-normal text-gray-400">
                            <x-forms.checkbox-input :checked="$item->permission ? true : false" />
                        </td>
                        <td class="p-10 font-normal text-gray-400">
                            <x-forms.checkbox-input :checked="$item->view ? true : false" />
                        </td>
                        <td class="p-10 font-normal text-gray-400">
                            <x-forms.checkbox-input :checked="$item->livewire_component ? true : false" />
                        </td>
                        <td class="p-10 font-normal text-gray-400">
                            <x-forms.checkbox-input :checked="$item->mcrp ? true : false" />
                        </td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('dashboard.module.edit', $item->id) }}" />
                                <x-actions.delete action="{{ route('dashboard.module.destroy', $item->id) }}" />
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
