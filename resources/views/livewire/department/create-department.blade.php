<section class="py-5">
    <form wire:submit="save">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="name" required='yes'>
                    {{ __('Department Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.blur='name' placeholder="Department name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.blur="status">
                    <option selected>--Select Status--</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-forms.select-input>

                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
            </div>
        </div>

        <div class="p-2">
            <x-buttons.primary>
                Create Department
            </x-buttons.primary>
        </div>
    </form>
</section>
