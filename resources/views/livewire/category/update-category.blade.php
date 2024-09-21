<section class="py-5">
    <form wire:submit="update">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="form.name" required='yes'>
                    {{ __('Category Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.live='form.name' placeholder="User name" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.parent_id">
                    {{ __('Parent Category') }}
                </x-forms.label>
                <x-forms.select-input wire:model.live="form.parent_id">
                    <option selected disabled>--Select Parent Category--</option>
                    @foreach ($parent_categories as $each)
                        <option value="{{ $each->id }}" @selected(old('parent_id', $category?->parent_id) == $each->id)>{{ $each->name }}</option>
                    @endforeach
                </x-forms.select-input>

                <x-input-error :messages="$errors->get('form.parent_id')" class="mt-2" />
            </div>

        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="form.status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.live="form.status">
                    <option disabled>--Select Status--</option>
                    <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                </x-forms.select-input>

                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.image">
                    {{ __('Image') }}
                </x-forms.label>
                <x-forms.text-input type="file" wire:model.live="form.image" />
                <x-input-error :messages="$errors->get('form.image')" class="mt-2" />
            </div>

        </div>

        <div class="p-2">
            <x-buttons.primary>
                Create Category
            </x-buttons.primary>
        </div>

    </form>
</section>
