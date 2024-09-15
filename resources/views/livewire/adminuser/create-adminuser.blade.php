 <section class="py-5">
     <form wire:submit="save">
         <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
             <div class="p-2 w-full">
                 <x-forms.label for="form.name" required='yes'>
                     {{ __('User Name') }}
                 </x-forms.label>
                 <x-forms.text-input type="text" wire:model.live='form.name' placeholder="User name" />
                 <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
             </div>

             <div class="p-2 w-full">
                 <x-forms.label for="form.email" required='yes'>
                     {{ __('User Email') }}
                 </x-forms.label>
                 <x-forms.text-input wire:model.live="form.email" type="email" placeholder="Enter user email" />
                 <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
             </div>

         </div>

         <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
             <div class="p-2 w-full">
                 <x-forms.label for="form.password" required='yes'>
                     {{ __('User password') }}
                 </x-forms.label>
                 <x-forms.text-input wire:model.live="form.password" type="password" placeholder="Enter user password" />
                 <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
             </div>

             <div class="p-2 w-full">
                 <x-forms.label for="role_id" required='yes'>
                     {{ __('User Role') }}
                 </x-forms.label>

                 <x-forms.select-input wire:model.live="form.role_id">
                     <option selected disabled>--User Role--</option>
                     @forelse ($roles as $role)
                         <option value="{{ $role?->id }}">{{ $role?->name }}</option>
                     @empty
                         <option disabled>--No Roles Found--</option>
                     @endforelse
                     </x-forms-select-input>
                     <x-input-error :messages="$errors->get('form.role_id')" class="mt-2" />
             </div>
         </div>

         <div class="p-2">
             <x-buttons.primary>
                 Add User
             </x-buttons.primary>
         </div>

     </form>
 </section>
