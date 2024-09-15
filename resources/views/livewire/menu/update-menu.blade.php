<section class="py-5">
    <form wire:submit="update" method="POST">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="name" required='yes'>
                    {{ __('Menu Name') }}
                </x-forms.label>
                <x-forms.text-input type="text" value="{{ $menu->name }}" wire:model.blur="name"
                    placeholder="Menu name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="parent_id">
                    {{ __('Parent Menu') }}
                </x-forms.label>
                <x-forms.select-input wire:model="parent_id">
                    <option selected value="">Select Parent (optional)</option>
                    @foreach ($parent_menus as $parent_menu)
                        <option @selected(old('parent_id', $menu?->parent_id) == $parent_menu?->id) value="{{ $parent_menu->id }}">{{ $parent_menu->name }}
                        </option>
                    @endforeach
                </x-forms.select-input>
            </div>
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="route" required='yes'>
                    {{ __('Route name') }}
                </x-forms.label>
                <x-forms.text-input type="text" value="{{ $menu->route }}" wire:model.blur="route"
                    placeholder="Route name" />
                <x-input-error :messages="$errors->get('route')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="url">
                    {{ __('Url') }}
                </x-forms.label>
                <x-forms.text-input type="text" value="{{ $menu->url }}" wire:model.blur="url"
                    placeholder="Full url" />
                <x-input-error :messages="$errors->get('url')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="role" required='yes'>
                    {{ __('Role') }}
                </x-forms.label>
                <x-forms.nice-select wire:model.blur="role" multiple>
                    <option disabled> Select Role</option>
                    @foreach ($roles as $role)
                        <option {{ in_array($role->name, json_decode($menu->roles, true)) ? 'selected' : '' }}
                            value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}</option>
                    @endforeach
                </x-forms.nice-select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="p-2 w-full">
                <x-forms.label for="status" required='yes'>
                    {{ __('Status') }}
                </x-forms.label>
                <x-forms.select-input wire:model.blur="status">
                    <option value="active" {{ $menu->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deactive" {{ $menu->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                </x-forms.select-input>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="icon">
                    {{ __('Svg icon') }}
                </x-forms.label>
                <textarea wire:model="icon" rows="2"
                    class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded" placeholder="Svg icon"></textarea>
            </div>
        </div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="p-2 w-full">
                <x-forms.label for="order">
                    {{ __('Order') }}
                </x-forms.label>
                <x-forms.text-input type="number" wire:model.blur="order" value="{{ $menu->order }}"
                    placeholder="Menu Order" />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>
        </div>

        <div class="p-2">
            <x-buttons.primary>
                Update Menu
            </x-buttons.primary>
        </div>

    </form>
</section>
