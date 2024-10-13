<x-offcanvas :position="'end'" :size="'md'" :eventname="'offcanvas-requester'">

    @slot('header')
        New Requester
    @endslot
    @slot('body')
        <form action="" method="POST">
            @csrf
            <div>
                <div class="border border-slate-300 p-2 rounded">

                    <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="form.requester_type">
                                {{ __('Select requester') }}
                            </x-forms.label>

                            <select class="w-full select2" style="width: 100%" id="userOnChabge">
                                <option selected disabled>Select requester</option>
                                @foreach ($users as $each)
                                    <option value="{{ $each->id }}">
                                        {{ $each?->name }} ({{ $each?->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-1 mt-1">
                        <h3 class="text-center text-lg">OR</h3>
                    </div>
                    <div class="grid sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="requester_name" required='yes'>
                                {{ __('Requester Name') }}
                            </x-forms.label>
                            <x-forms.text-input type="text" wire:model='requester_name' value=""
                                id="requester_name" />
                            <x-input-error :messages="$errors->get('requester_name')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="requester_email" required="yes">
                                {{ __('Requester Email') }}
                            </x-forms.label>
                            <x-forms.text-input wire:model="requester_email" type="email" value=""
                                id="requester_email" />
                            <x-input-error :messages="$errors->get('requester_email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="requester_phone">
                                {{ __('Requester Phone') }}
                            </x-forms.label>
                            <x-forms.text-input type="number" wire:model='requester_phone' value=""
                                id="requester_phone" />
                            <x-input-error :messages="$errors->get('requester_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="requester_type">
                                {{ __('Requester Type') }}
                            </x-forms.label>

                            <x-forms.select-input wire:model="requester_type_id" id="requester_type_id">
                                <option selected value>Requester type</option>
                                @foreach ($requester_type as $each)
                                    <option value="{{ $each->id }}">
                                        {{ $each?->name }}
                                    </option>
                                @endforeach
                            </x-forms.select-input>

                            <x-input-error :messages="$errors->get('requester_type_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.label for="requester_id">
                                {{ __('Requester Id') }}
                            </x-forms.label>
                            <x-forms.text-input type="number" wire:model='requester_id' value="" id="requester_id" />
                            <x-input-error :messages="$errors->get('requester_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="p-2">
                        <x-buttons.primary>
                            Add New Requster
                        </x-buttons.primary>
                    </div>
                </div>
            </div>
        </form>
    @endslot
</x-offcanvas>