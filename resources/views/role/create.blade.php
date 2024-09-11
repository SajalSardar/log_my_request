<x-app-layout>
    {{-- 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('dashboard.role.store') }}" method="POST">
                        @csrf
                        <input type="text" name="role" placeholder="Role Name">
                        <div class="my-3">
                            @forelse ($modules as $module)
                                <h3 class="mb-2">{{ $module->name }}</h3>
                                @foreach ($module->permissions as $permission)
                                    <label>
                                        <input type="checkbox" value="{{ $permission->name }}" name="permission[]">
                                        {{ $permission->name }}
                                    </label>
                                @endforeach
                                <hr class="my-3">

                            @empty
                            @endforelse

                        </div>

                        <div>
                            <button type="submit"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> --}}

    <form wire:submit="saveMenu" method="POST">
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
                        <label>
                            {{-- <input type="checkbox" value="{{ $permission->name }}" name="permission[]"> --}}
                            <x-forms.checkbox-input type="checkbox" value="{{ $permission->name }}" name="permission[]" />
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
