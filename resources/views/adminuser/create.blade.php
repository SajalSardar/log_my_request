<x-app-layout>
    <div class="p-5 rounded-lg shadow-lg">
        <header class="py-5 px-2 grid md:grid-cols-2 sm:grid-cols-1 md:gap-1 sm:gap-1">
            <div class="infos">
                <h3 class="font-bold text-xl">Create Users By Admin</h3>
                <p>Please fill the input field where sign <span class="text-red-500">(*) </span> have.</p>
            </div>

            <div class="flex md:flex-row-reverse sm:flex-row">
               <div>
                <x-actions.href href="{{ route('admin.user.index') }}">
                    {{ __('Users') }}
                </x-actions.href>
               </div>
            </div>
        </header>
        <hr>
        <livewire:adminuser.create-adminuser />
    </div>
</x-app-layout>
