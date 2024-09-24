 <form wire:submit="save">
     <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
         <div class="border border-slate-300 p-5 rounded">
             <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">

                 <div class="p-2 w-full">
                     <x-forms.label for="form.request_id" required='yes'>
                         {{ __('Request ID') }}
                     </x-forms.label>
                     <x-forms.text-input type="text" wire:model.live='form.request_id' />
                     <x-input-error :messages="$errors->get('form.request_id')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.request_title" required="yes">
                         {{ __('Request Title') }}
                     </x-forms.label>
                     <x-forms.text-input wire:model.live="form.request_title" type="text" />
                     <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                 </div>

             </div>

             <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4 p-2 w-full ">
                 <x-forms.label for="form.request_description">
                     {{ __('Request Description') }}
                 </x-forms.label>
                 <textarea cols="30" rows="10"wire:model.live='form.request_description' class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded" placeholder="Add description here.."></textarea>
                 <x-input-error :messages="$errors->get('form.request_description')" class="mt-2" />
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_name" required='yes'>
                         {{ __('Requester Name') }}
                     </x-forms.label>
                     <x-forms.text-input type="text" wire:model.live='form.requester_name' />
                     <x-input-error :messages="$errors->get('form.requester_name')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_email" required="yes">
                         {{ __('Requester Email') }}
                     </x-forms.label>
                     <x-forms.text-input wire:model.live="form.requester_email" type="email" />
                     <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_phone">
                         {{ __('Requester Phone') }}
                     </x-forms.label>
                     <x-forms.text-input type="number" wire:model.live='form.requester_phone' />
                     <x-input-error :messages="$errors->get('form.requester_phone')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_type" required="yes">
                         {{ __('Requester Type') }}
                     </x-forms.label>

                     <x-forms.nice-select wire:model.live="form.requester_email">
                         <option value="">--Requester type--</option>
                         @foreach ($requester_type as $each)
                             <option value="{{ $each->id }}">{{ $each?->name }}</option>
                         @endforeach
                     </x-forms.nice-select>

                     <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_id" required='yes'>
                         {{ __('Requester ID') }}
                     </x-forms.label>
                     <x-forms.text-input type="text" wire:model.live='form.requester_id' />
                     <x-input-error :messages="$errors->get('form.requester_id')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.priority" required="yes">
                         {{ __('Requester Priority') }}
                     </x-forms.label>
                     <div class="mt-3">
                         <x-forms.radio-input wire:model.live="form.priority" name="priority" class="ml-2" /> <span class="ml-2">Low</span>
                         <x-forms.radio-input wire:model.live="form.priority" name="priority" class="ml-2" /> <span class="ml-2">Medium</span>
                         <x-forms.radio-input wire:model.live="form.priority" name="priority" class="ml-2" /> <span class="ml-2">High</span>
                     </div>
                     <x-input-error :messages="$errors->get('form.priority')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-3 sm:grid-cols-3">
                 <div class="p-2">
                     <x-forms.label for="form.due_date" required='yes'>
                         {{ __('Due Date') }}
                     </x-forms.label>
                     <x-forms.text-input type="date" wire:model.live='form.due_date' />
                     <x-input-error :messages="$errors->get('form.due_date')" class="mt-2" />
                 </div>

                 <div class="p-2">
                     <x-forms.label for="form.source" required="yes">
                         {{ __('Source') }}
                     </x-forms.label>

                     <x-forms.nice-select wire:model.live="form.source">
                         <option value="">--Source--</option>
                         @foreach ($sources as $each)
                             <option value="{{ $each->id }}">{{ $each?->name }}</option>
                         @endforeach
                     </x-forms.nice-select>

                     <x-input-error :messages="$errors->get('form.source')" class="mt-2" />
                 </div>
                 <div class="p-2">
                     <x-forms.label for="form.category" required="yes">
                         {{ __('Category') }}
                     </x-forms.label>

                     <x-forms.nice-select wire:model.live="form.category">
                         <option value="">--Category--</option>
                         @foreach ($categories as $each)
                             <option value="{{ $each->id }}">{{ $each?->name }}</option>
                         @endforeach
                     </x-forms.nice-select>

                     <x-input-error :messages="$errors->get('form.category')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-3 sm:grid-cols-3">
                 <div class="p-2">
                     <x-forms.label for="form.assign_team" required='yes'>
                         {{ __('Assign Team') }}
                     </x-forms.label>
                     <x-forms.nice-select wire:model.live="form.assign_team">
                         <option value="">--Assign Team--</option>
                         @foreach ($sources as $each)
                             <option value="{{ $each->id }}">{{ $each?->name }}</option>
                         @endforeach
                     </x-forms.nice-select>
                     <x-input-error :messages="$errors->get('form.assign_team')" class="mt-2" />
                 </div>

                 <div class="p-2">
                     <x-forms.label for="form.assigned_agent" required="yes">
                         {{ __('Assign Agent') }}
                     </x-forms.label>

                     <x-forms.nice-select wire:model.live="form.assigned_agent">
                         <option value="">--Assign Agent--</option>
                         @foreach ($sources as $each)
                             <option value="{{ $each->id }}">{{ $each?->name }}</option>
                         @endforeach
                     </x-forms.nice-select>

                     <x-input-error :messages="$errors->get('form.assigned_agent')" class="mt-2" />
                 </div>
                 <div class="p-2">
                     <x-forms.label for="form.status" required="yes">
                         {{ __('Status') }}
                     </x-forms.label>

                     <x-forms.nice-select wire:model.live="form.status">
                         <option value="">--Status--</option>

                     </x-forms.nice-select>

                     <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                 </div>
             </div>
             <div class="p-2">
                 <x-buttons.secondary>
                     Cancel
                     </x-buttons.primary>
                     <x-buttons.primary>
                         Create Team
                     </x-buttons.primary>
             </div>




         </div>

         <!-- Un used div !-->
         <div></div>



     </div>





 </form>
