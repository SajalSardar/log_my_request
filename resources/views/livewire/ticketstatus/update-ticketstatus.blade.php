<div class="border border-slate-300 p-5 rounded">
    <div class="flex justify-end pb-3 fixed top-24 right-10">
        <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded"
            href="{{ route('admin.ticketstatus.index') }}">
            {{ __('Status List') }}
        </a>
    </div>
    <header class="flex justify-between mb-5">
        <h4>{{ __('Edit Status') }}</h4>

    </header>
    <form wire:submit="update">
        <div class="flex justify-between">
            <div class="p-2 w-full">
                <x-forms.text-input type="text" placeholder="Status Name" wire:model.blur="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>
        <div class="flex justify-between">
            <div class="p-2 w-full">
                <x-forms.select-input wire:model.blur="status">
                    <option value="" disabled selected>Select Status</option>
                    <option value="1">Active</option>
                    <option value="2">Deactive</option>
                </x-forms.select-input>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
        </div>

        <div class="p-2">
            <x-buttons.primary>
                {{ __('Update Status') }}
            </x-buttons.primary>
        </div>

    </form>
</div>
