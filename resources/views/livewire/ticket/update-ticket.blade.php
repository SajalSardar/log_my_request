<form wire:submit="update">
    <div class="flex flex-row">
        <div class="md:basis-2/3 sm:basis-full">
            <div class="border border-slate-300 p-5 rounded">

                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.request_title" required="yes">
                            {{ __('Request Title') }}
                        </x-forms.label>
                        <x-forms.text-input wire:model="form.request_title" value="{{ $ticket?->title }}"
                            type="text" />
                        <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4 p-2 w-full ">
                    <x-forms.label for="form.request_description">
                        {{ __('Request Description') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <textarea wire:ignore cols="30" id="editor" rows="10" wire:model.lazy='form.request_description'
                            class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                            placeholder="Add description here..">{!! $ticket->description !!}</textarea>
                        <x-input-error :messages="$errors->get('form.request_description')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.input-file wire:model="form.request_attachment" multiple
                            accept=".jpg, .jpeg, .png, .pdf,.docx,.ppt" />
                        <x-input-error :messages="$errors->get('form.request_attachment')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.requester_name" required='yes'>
                            {{ __('Requester Name') }}
                        </x-forms.label>
                        <x-forms.text-input type="text" readonly wire:model='form.requester_name'
                            value="{{ $ticket?->user?->name }}" />
                        <x-input-error :messages="$errors->get('form.requester_name')" class="mt-2" />
                    </div>
                    <div class="p-2 w-full">
                        <x-forms.label for="form.requester_email" required="yes">
                            {{ __('Requester Email') }}
                        </x-forms.label>
                        <x-forms.text-input wire:model="form.requester_email" readonly type="email"
                            value="{{ $ticket?->user?->email }}" />
                        <x-input-error :messages="$errors->get('form.requester_email')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.requester_phone">
                            {{ __('Requester Phone') }}
                        </x-forms.label>
                        <x-forms.text-input type="number" readonly wire:model='form.requester_phone'
                            value="{{ $ticket?->user?->phone }}" />
                        <x-input-error :messages="$errors->get('form.requester_phone')" class="mt-2" />
                    </div>
                    <div class="p-2 w-full">
                        <x-forms.label for="form.requester_type">
                            {{ __('Requester Type') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.requester_type_id">
                            <option selected value>Requester type</option>
                            @foreach ($requester_type as $each)
                                <option @selected(old('form.requester_type_id', $ticket?->user->requester_type_id) == $each?->id) value="{{ $each->id }}">{{ $each?->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.requester_type_id')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.requester_id" value="{{ $ticket?->user->requester_id }}">
                            {{ __('Requester ID') }}
                        </x-forms.label>
                        <x-forms.text-input type="text" wire:model='form.requester_id' />
                        <x-input-error :messages="$errors->get('form.requester_id')" class="mt-2" />
                    </div>
                    <div class="p-2 w-full">
                        <x-forms.label for="form.priority" required="yes">
                            {{ __('Requester Priority') }}
                        </x-forms.label>
                        <div class="mt-3">
                            <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2"
                                value="low" /> <span class="ml-2">Low</span>
                            <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2"
                                value="medium" /> <span class="ml-2">Medium</span>
                            <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2"
                                value="high" /> <span class="ml-2">High</span>
                        </div>
                        <x-input-error :messages="$errors->get('form.priority')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1">
                    <div class="p-2">
                        <x-forms.label for="form.due_date">
                            {{ __('Due Date') }}
                        </x-forms.label>
                        <x-forms.text-input type="date" wire:model='form.due_date'
                            value="{{ $ticket?->due_date }}" />
                        <x-input-error :messages="$errors->get('form.due_date')" class="mt-2" />
                    </div>

                    <div class="p-2">
                        <x-forms.label for="form.source_id">
                            {{ __('Source') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.source_id">
                            <option selected value>Source</option>
                            @foreach ($sources as $each)
                                <option @selected(old('form.source_id', $ticket?->source_id) == $each?->id) value="{{ $each->id }}">{{ $each?->title }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.source_id')" class="mt-2" />
                    </div>

                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1">
                    <div class="p-2">
                        <x-forms.label for="form.category_id" required="yes">
                            {{ __('Category') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.category_id" id="category_id"
                            wire:change="selectChildeCategory">
                            <option disabled value>Category</option>
                            @foreach ($categories as $each)
                                <option @selected(old('form.category_id', $ticket?->category_id) == $each?->id) value="{{ $each?->id }}">
                                    {{ $each?->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>
                        <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />

                        @if ($subCategory && $subCategory->count() > 0)
                            <div class="mt-2">
                                <x-forms.label for="sub_category_id" required="yes">
                                    {{ __('Sub Category') }}
                                </x-forms.label>
                                <x-forms.select-input wire:model="form.sub_category_id" id="sub_category_id" required>
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subCategory as $each)
                                        <option value="{{ $each?->id }}" :key="{{ $each->id }}">
                                            {{ $each?->name }}
                                        </option>
                                    @endforeach
                                </x-forms.select-input>

                                <x-input-error :messages="$errors->get('form.sub_category_id')" class="mt-2" />
                            </div>
                        @endif
                    </div>
                    <div class="p-2">
                        <x-forms.label for="form.ticket_status_id" required="yes">
                            {{ __('Status') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.ticket_status_id">
                            <option value="">Ticket status</option>
                            @foreach ($ticket_status as $status)
                                <option @selected(old('form.ticket_status_id', $ticket?->ticket_status_id) == $each?->id) value="{{ $status->id }}">{{ $status->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.ticket_status_id')" class="mt-2" />
                    </div>
                </div>
                <div class="grid md:grid-cols-3 sm:grid-cols-1">
                    <div class="p-2">
                        <x-forms.label for="department_id_select">
                            {{ __('Department') }}
                        </x-forms.label>
                        <div>
                            <x-forms.select-input wire:model="form.department_id" wire:change="selectDepartemntTeam">
                                <option value="">Select Department</option>
                                @foreach ($departments as $each)
                                    <option value="{{ $each->id }}" :key="{{ $each->id }}">
                                        {{ $each?->name }}
                                    </option>
                                @endforeach
                            </x-forms.select-input>
                            <x-input-error :messages="$errors->get('form.department_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="p-2">
                        <x-forms.label for="form.team_id">
                            {{ __('Assign Team') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.team_id" wire:change="selectTeamAgent">
                            <option value="">Select a Team</option>
                            @foreach ($teams as $each)
                                <option value="{{ $each->id }}" @selected($form->team_id == $each->id)>{{ $each->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.team_id')" class="mt-2" />
                    </div>

                    <div class="p-2">
                        <x-forms.label for="form.owner_id">
                            {{ __('Assign Agent') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.owner_id">
                            <option value="">Select Agent</option>
                            @foreach ($teamAgent as $item)
                                <option
                                    {{ in_array($item->id, $ticket?->owners?->pluck('id')->toArray()) ? 'selected' : '' }}
                                    value="{{ $item?->id }}">
                                    {{ $item?->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.owner_id')" class="mt-2" />
                    </div>

                </div>
                <div class="p-2">
                    <x-buttons.primary>
                        Update Request
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</form>
@section('style')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
            /* Adjust the height to your preference */
        }
    </style>
@endsection
@section('script')
    <script>
        const editor = ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('form.request_description', editor.getData());
                })
            }).catch(error => {
                console.error(error);
            });

        document.addEventListener('DOMContentLoaded', function() {

            let attachment = document.querySelector('#attachment');
            let attachmentName = document.querySelector('#attachmentName');

            attachment.addEventListener('change', function(event) {
                event.preventDefault();
                let files = event.target.files;
                if (files.length > 0) {
                    let filename = files[0].name;
                    attachmentName.innerHTML = filename;
                }
            });

            // initSelect2form('category_id');
        });
    </script>
@endsection
