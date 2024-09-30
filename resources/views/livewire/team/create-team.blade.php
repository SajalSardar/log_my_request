<section class="py-5">
    <form wire:submit="save">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="form.name" required='yes'>
                    {{ __('Team Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.blur='form.name' placeholder="Team name" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.image">
                    {{ __('Team Image') }}
                </x-forms.label>
                <x-forms.text-input wire:model.blur="form.image" accept="jpg,png,jpeg" max='3024' type="file" />
                <x-input-error :messages="$errors->get('form.image')" class="mt-2" />
            </div>

        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="form.category_id">
                    {{ __('Team Category') }}
                </x-forms.label>

                <div wire:ignore>
                    <x-forms.select2-select wire:model='form.category_id' id="category_id" multiple>
                        <option value="" disabled>Select Category</option>
                        @foreach ($categories as $each)
                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                        @endforeach
                    </x-forms.select2-select>
                    <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />
                </div>

            </div>

            <div class="p-2 w-full">
                <x-forms.label for="form.status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.blur='form.status'>
                    <option selected>Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-forms.select-input>
                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
            </div>

        </div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="form.agent_id">
                    {{ __('Agent') }}
                </x-forms.label>
                <div wire:ignore>
                    <x-forms.select2-select wire:model='form.agent_id' id="agent_id" multiple>
                        <option value="" disabled>Select agent</option>
                        @foreach ($agentUser as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </x-forms.select2-select>

                    <x-input-error :messages="$errors->get('form.agent_id')" class="mt-2" />
                </div>
            </div>

        </div>

        <div class="p-2">
            <x-buttons.primary>
                Create Team
            </x-buttons.primary>
        </div>

    </form>
</section>
