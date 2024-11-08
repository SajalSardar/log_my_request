<x-app-layout>
    @section('title', 'Create Role')
    @section('breadcrumb')
    <x-breadcrumb>
        Create Role
    </x-breadcrumb>
    @endsection

    <form wire:submit="saveMenu" method="POST">
        <div class="flex justify-between mb-[24px]">
            <h3 class="font-inter font-semibold text-[#333] text-[20px]">Create Role By Admin</h3>
            <div>
                <a href="{{ route('admin.role.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                    Go to Role Lists
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div>
                <label for="form.name" class="text-sm font-semibold font-inter text-[#333] inline-block mb-2">
                    {{ __('Role Name') }}
                    <span class="text-red-500">*</span>
                </label>
                <x-forms.text-input type="text" name="role" placeholder="role name..." />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="mt-6">
                @forelse ($modules as $module)
                    <h3 class="text-heading-dark mb-2">{{ $module->name }}</h3>
                    <span class="flex gap-3 flex-wrap items-center">
                        @foreach ($module->permissions as $permission)
                            <label class="flex gap-2 items-center border border-base-500 py-1.5 px-5 rounded">
                                <x-forms.checkbox-input type="checkbox" value="{{ $permission->name }}" name="permission[]" />
                                <span class="text-paragraph">{{ camelCase($permission->name) }}</span>
                            </label>
                        @endforeach
                    </span>
                    <hr class="my-3">
                @empty
                @endforelse
            </div>
        </div>

        <div class="pt-2">
            <x-buttons.primary>
                Create
            </x-buttons.primary>
        </div>
    </form>
</x-app-layout>