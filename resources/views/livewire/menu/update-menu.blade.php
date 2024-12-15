<form wire:submit="update" method="POST">
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="flex justify-between mb-[24px]">
            <h3 class="text-detail-heading">Update Menu</h3>
            <a href="{{ route('admin.menu.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                Menu Lists
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="border border-base-500 p-5 rounded">
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pb-2 w-full">
                    <x-forms.label for="name" required='yes'>
                        {{ __('Menu Name') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" value="{{ $menu->name }}" wire:model.blur="name" placeholder="Menu name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
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

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.select-input wire:model.blur="route" placeholder="Route name">
                        <option selected disabled>Route Name</option>
                        @if (is_object($routes) && $routes->count() > 0)
                        @forelse ($routes as $each)
                        <option {{ in_array($menu->route, $routes->toArray()) ? 'selected' : '' }} value="{{ $each }}">{{ ucfirst($each) }}</option>
                        @empty
                        <option disabled>No route Found</option>
                        @endforelse
                        @endif
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('route')" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="url">
                        {{ __('Url (optional)') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" value="{{ $menu->url }}" wire:model.blur="url" placeholder="Full url" />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="role">
                        {{ __('Role') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer="role" id="role" multiple>
                            <option disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option {{ in_array($role->name, json_decode($menu->roles, true)) ? 'selected' : '' }} value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}</option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="permission">
                        {{ __('Permission') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer="permission" id="permission" multiple>
                            <option disabled>Select permission</option>
                            @foreach ($permission_list as $list)
                            @php
                                $lists = $menu->permissions ? json_decode($menu->permissions, true): [];
                            @endphp
                            <option {{ in_array($list->name, $lists) ? 'selected' : '' }} value="{{ $list->name }}">{{ Str::ucfirst($list->name) }}</option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('permission')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="status" required='yes'>
                        {{ __('Status') }}
                    </x-forms.label>
                    <x-forms.select-input wire:model.blur="status">
                        <option value="active" {{ $menu->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $menu->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="icon">
                        {{ __('SVG icon') }}
                    </x-forms.label>
                    <textarea wire:model="icon" rows="1" class="w-full py-2 text-paragraph focus:ring-primary-400 focus:border-primary-400 dark:focus:ring-primary-400 dark:focus:border-primary-400 border border-base-500 rounded" placeholder="Svg icon"></textarea>
                </div>
            </div>

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="order">
                        {{ __('Order') }}
                    </x-forms.label>
                    <x-forms.text-input type="number" wire:model.blur="order" value="{{ $menu->order }}" placeholder="Menu Order" />
                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                </div>
            </div>

            <div class="pt-6">
                <x-buttons.primary>
                    Update
                </x-buttons.primary>
            </div>

        </div>
    </div>
</form>