<x-app-layout>
    @section('title', 'Create Role')
    @section('breadcrumb')
        <x-breadcrumb>
            Create Role
        </x-breadcrumb>
    @endsection

    <form  method="POST" action="{{ route('admin.role.store') }}">
        @csrf
        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2">
                <x-forms.text-input type="text" name="role" placeholder="Role name" />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2">
                @forelse ($modules as $module)
                    <h3 class="mb-2">{{ $module->name }}</h3>
                    @foreach ($module->permissions as $permission)
                        <label class="border border-gray-100 p-1 m-2 inline-block">
                            {{-- <input type="checkbox" value="{{ $permission->name }}" name="permission[]"> --}}
                            <x-forms.checkbox-input type="checkbox" value="{{ $permission->name }}"
                                name="permission[]" />
                            {{ $permission->name }}
                        </label>
                    @endforeach
                    <hr class="my-3">
                @empty
                @endforelse

            </div>
        </div>


        <div class="p-2">
            <x-buttons.primary>
                Add Role
            </x-buttons.primary>
        </div>

    </form>

</x-app-layout>
