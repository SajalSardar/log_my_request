<form wire:submit="save">
    <div class="flex justify-between" style="width:651px !important">
        <h3 class="font-inter font-semibold text-[#333] text-[20px] mb-[24px]">Create User By Admin</h3>
        <div>
            <a href="{{ route('admin.user.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                Go to User Lists
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-row">
        <div style="width:651px !important">
            <div class="border border-base-500 p-5 rounded">
                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.name" required='yes'>
                            {{ __('User Name') }}
                        </x-forms.label>
                        <x-forms.text-input type="text" wire:model.live='form.name' placeholder="User name" />
                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                    </div>
                </div>
                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.email" required='yes'>
                            {{ __('User Email') }}
                        </x-forms.label>
                        <x-forms.text-input wire:model.live="form.email" type="email" placeholder="Enter user email" />
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>
                </div>

                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.password" required='yes'>
                            {{ __('User password') }}
                        </x-forms.label>
                        <x-forms.text-input wire:model.live="form.password" type="password" placeholder="Enter user password" />
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>
                </div>

                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                    <div class="p-2 w-full">
                        <x-forms.label for="role_id" required="yes">
                            {{ __('User Role') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model.live="form.role_id">
                            <option selected disabled>User Role</option>
                            @forelse ($roles as $role)
                                <option value="{{ $role?->id }}">{{ ucfirst($role?->name) }}</option>
                            @empty
                                <option disabled>No Roles Found</option>
                            @endforelse
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.role_id')" class="mt-2" />
                    </div>
                </div>

                <div class="p-2 mt-[7px]">
                    <x-buttons.primary>
                        Create
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</form>