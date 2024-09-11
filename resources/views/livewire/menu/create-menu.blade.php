<section class="py-5">
    {{-- <form wire:submit="saveMenu" method="POST">
        <div class="p-2 w-full">
            <x-forms.text-input type="text" wire:model.live="name" placeholder="Menu Name*" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="p-2 w-full">
            <x-forms.select-input wire:model="parent_id">
                <option selected value="">Select Parent (optional)</option>
                @foreach ($parent_menus as $parent_menu)
                    <option value="{{ $parent_menu->id }}">{{ $parent_menu->name }}</option>
                @endforeach
            </x-forms.select-input>
        </div>
        <div class="p-2 w-full">
            <x-forms.text-input type="text" wire:model.live="route" placeholder="Route name*" />
            <x-input-error :messages="$errors->get('route')" class="mt-2" />
        </div>
        <div class="p-2 w-full">
            <x-forms.text-input type="text" wire:model.live="url" placeholder="Url" />
            <x-input-error :messages="$errors->get('url')" class="mt-2" />
        </div>

        <div class="p-2 w-full">
            <textarea wire:model="icon" id="" rows="4" class="w-full" placeholder="Svg Icon"></textarea>
        </div>

        <div class="p-2 w-full">
            <x-forms.nice-select wire:model="role" multiple>
                <option selected disabled> Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}</option>
                @endforeach
            </x-forms.nice-select>
        </div>

        <div class="p-2 w-full">
            <x-forms.select-input wire:model.live="status">
                <option value="active" selected>Active</option>
                <option value="deactive">Deactive</option>
            </x-forms.select-input>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="p-2">
            <x-buttons.primary>
                Save
            </x-buttons.primary>
        </div>

    </form> --}}

    <form wire:submit="saveMenu" method="POST">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

            <div class="p-2 w-full">
                <x-forms.label for="name" required='yes'>
                    {{ __('Menu Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.live="name" placeholder="Menu name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="parent_id">
                    {{ __('Parent Menu') }}
                </x-forms.label>
                <x-forms.select-input wire:model="parent_id">
                    <option selected value="">Select Parent (optional)</option>
                    @foreach ($parent_menus as $parent_menu)
                        <option value="{{ $parent_menu->id }}">{{ $parent_menu->name }}</option>
                    @endforeach
                </x-forms.select-input>
            </div>
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="route" required='yes'>
                    {{ __('Route name') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.live="route" placeholder="Route name" />
                <x-input-error :messages="$errors->get('route')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="url" required='yes'>
                    {{ __('Url') }}
                </x-forms.label>
                <x-forms.text-input type="text" wire:model.live="url" placeholder="Full url" />
                <x-input-error :messages="$errors->get('url')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="role" required='yes'>
                    {{ __('Role') }}
                </x-forms.label>
                <x-forms.nice-select wire:model="role" multiple>
                    <option selected disabled> Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}</option>
                    @endforeach
                </x-forms.nice-select>
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.live="status">
                    <option value="active" selected>Active</option>
                    <option value="deactive">Deactive</option>
                </x-forms.select-input>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="icon" required='yes'>
                    {{ __('Svg icon') }}
                </x-forms.label>
                <textarea wire:model="icon" rows="2" class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded" placeholder="Svg icon"></textarea>
            </div>
        </div>

        <div class="p-2">
            <x-buttons.primary>
                Add Menu
            </x-buttons.primary>
        </div>

    </form>

</section>
