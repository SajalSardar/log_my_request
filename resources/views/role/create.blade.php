<x-app-layout>

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
