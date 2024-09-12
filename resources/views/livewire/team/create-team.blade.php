<section class="py-5">
    <form wire:submit="save">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="form.name" required='yes'>
                    {{ __('Team Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.live='form.name' placeholder="Team name" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.image" required='yes'>
                    {{ __('Team Image') }}
                </x-forms.label>
                <x-forms.text-input wire:model.live="form.image" accept="jpg,png,jpeg" max='3024' type="file" />
                <x-input-error :messages="$errors->get('form.image')" class="mt-2" />
            </div>

        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="form.category_id">
                    {{ __('Team Category') }}
                </x-forms.label>

                <x-forms.nice-select wire:model.live='form.category_id' multiple>
                    <option selected disabled>--Select Category--</option>
                    @foreach ($categories as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                    @endforeach
                </x-forms.nice-select>

                <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.nice-select wire:model.live='form.status'>
                    <option selected>--Select Status--</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-forms.nice-select>
                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
            </div>

        </div>

        <div class="p-2">
            <x-buttons.primary>
                Create Team
            </x-buttons.primary>
        </div>

    </form>
</section>
