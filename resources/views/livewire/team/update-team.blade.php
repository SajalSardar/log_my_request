<section class="py-5">
    <form wire:submit="update">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="name" required='yes'>
                    {{ __('Team Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.blur='name' placeholder="Team name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="image">
                    {{ __('Team Image') }}
                </x-forms.label>
                <x-forms.text-input wire:model.blur="image" accept="jpg,png,jpeg" max='3024' type="file" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="categories_input">
                    {{ __('Team Category') }}
                </x-forms.label>

                <div wire:ignore>
                    <x-forms.select2-select wire:model.defer='categories_input' id="categories_input" multiple>
                        <option disabled value="">Select Category</option>
                        @foreach ($categories as $each)
                            <option value="{{ $each->id }}" @if (in_array($each->id, $categories_input)) selected @endif>
                                {{ $each->name }}
                            </option>
                        @endforeach
                    </x-forms.select2-select>
                </div>
                <x-input-error :messages="$errors->get('categories_input')" class="mt-2" />

            </div>

            <div class="p-2 w-full">
                <x-forms.label for="status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.blur='status'>
                    <option selected disabled>Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-forms.select-input>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

        </div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="agent_id">
                    {{ __('Agent') }}
                </x-forms.label>
                <div wire:ignore>
                    <x-forms.select2-select wire:model='agent_id' id="agent_id" multiple>
                        <option disabled value="">Select agent</option>
                        @foreach ($agentUser as $agent)
                            <option value="{{ $agent->id }}" @if (in_array($agent->id, $agent_id)) selected @endif>
                                {{ $agent->name }}</option>
                        @endforeach
                    </x-forms.select2-select>

                    <x-input-error :messages="$errors->get('agent_id')" class="mt-2" />
                </div>
            </div>

        </div>

        <div class="p-2">
            <x-buttons.primary>
                {{ __('Update Team') }}
            </x-buttons.primary>
        </div>

    </form>
</section>
