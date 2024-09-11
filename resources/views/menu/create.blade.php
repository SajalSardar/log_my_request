<x-app-layout>
    <div class="p-5 rounded-lg shadow-lg">
        <header class="py-5 px-2 grid md:grid-cols-2 sm:grid-cols-1 md:gap-1 sm:gap-1">
            <div class="infos">
                <h3 class="font-bold text-xl">Create Menus</h3>
                <p>Please fill the input field where sign <span class="text-red-500">(*) </span> have.</p>
            </div>

            <div class="flex md:flex-row-reverse sm:flex-row">
                <div>
                    <x-actions.href href="{{ route('dashboard.menu.index') }}">
                        {{ __('Menus') }}
                    </x-actions.href>
                </div>
            </div>
        </header>
        <hr>
        <livewire:menu.create-menu :roles="$roles" :parent_menus="$parent_menus" />
    </div>
</x-app-layout>
