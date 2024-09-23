            <div class="border border-slate-300 p-5 rounded">
                <header class="flex justify-between mb-5">
                    <h4>Source Create</h4>
                    
                </header>
                <form wire:submit="save">
                    <div class="flex justify-between">
                        <div class="p-2 w-full">
                            <x-forms.text-input type="text" placeholder="Source Name" wire:model.blur="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="p-2 w-full">
                            <x-forms.select-input wire:model.blur="status">
                                <option value="" disabled selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Deactive</option>
                            </x-forms.select-input>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="p-2">
                        <x-buttons.primary>
                            Save Source
                        </x-buttons.primary>
                    </div>

                </form>
            </div>
