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
                <x-forms.label for="category_id">
                    {{ __('Team Category') }}
                </x-forms.label>

                <x-forms.select-input wire:model.blur='category_id' multiple>
                    <option selected disabled>Select Category</option>
                    @foreach ($categories as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                    @endforeach
                </x-forms.select-input>

                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.blur='status'>
                    <option selected>Select Status</option>
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
                <div>
                    <x-forms.select-input wire:model.blur='agent_id' multiple>
                        <option selected disabled>Select agent</option>
                        @foreach ($agentUser as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </x-forms.select-input>

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
