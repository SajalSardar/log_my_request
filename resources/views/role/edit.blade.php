<x-app-layout>
    @section('title', 'Edit Role')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Role
        </x-breadcrumb>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-text-input class="block mt-1 w-full mb-2" type="text" placeholder="Role Name"
                            value="{{ old('role', $role->name) }}" required name="role" />

                        <div class="my-3">
                            @forelse ($modules as $module)
                                <h3 class="mb-2 font-bold">{{ $module->name }}</h3>
                                @foreach ($module->permissions as $permission)
                                    <label class="border border-gray-100 p-1 m-2 inline-block">
                                        <input type="checkbox" value="{{ $permission->name }}"
                                            {{ @in_array(@$permission->id, @$rolePermmission) ? 'checked' : '' }}
                                            name="permission[]"> {{ Str::ucfirst($permission->name) }}
                                    </label>
                                @endforeach
                                <hr class="my-3">

                            @empty
                            @endforelse

                        </div>
                        <div>
                            <x-buttons.primary>
                                Update
                            </x-buttons.primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
