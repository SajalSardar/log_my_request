<x-app-layout>
    <header class="mb-6">
        <span class="text-base font-bold font-inter">Request ID & Title: {{ $ticket?->requester_id }} , {{ $ticket?->title }}</span>
    </header>

    <div class="flex flex-wrap" id="tabs-id">
        <div class="w-full">
            <ul class="flex mb-0 list-none bg-[#F3F4F6]">
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-primary-400 text-white" onclick="changeAtiveTab(event,'tab-detail')">
                        <i class="fas fa-space-shuttle text-base mr-1"></i> Details
                    </a>
                </li>
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400" onclick="changeAtiveTab(event,'tab-conversation')">
                        <i class="fas fa-cog text-base mr-1"></i> Conversations
                    </a>
                </li>
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400" onclick="changeAtiveTab(event,'tab-history')">
                        <i class="fas fa-briefcase text-base mr-1"></i> History
                    </a>
                </li>
            </ul>

            <div class="relative flex flex-col min-w-0 break-words bg-white w-full my-6">
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <div class="block" id="tab-detail">
                            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
                                <div class="col-span-2">
                                    <!-- Edit & Favorite Part Start !-->
                                    <div class="flex justify-between">
                                        <p class="text-base font-bold font-inter">Request Description</p>
                                        <div class="action flex">
                                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.2141 4.98239L17.6158 3.58063C18.39 2.80646 19.6452 2.80646 20.4194 3.58063C21.1935 4.3548 21.1935 5.60998 20.4194 6.38415L19.0176 7.78591M16.2141 4.98239L10.9802 10.2163C9.93493 11.2616 9.41226 11.7842 9.05637 12.4211C8.70047 13.058 8.3424 14.5619 8 16C9.43809 15.6576 10.942 15.2995 11.5789 14.9436C12.2158 14.5877 12.7384 14.0651 13.7837 13.0198L19.0176 7.78591M16.2141 4.98239L19.0176 7.78591" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M21 12C21 16.2426 21 18.364 19.682 19.682C18.364 21 16.2426 21 12 21C7.75736 21 5.63604 21 4.31802 19.682C3 18.364 3 16.2426 3 12C3 7.75736 3 5.63604 4.31802 4.31802C5.63604 3 7.75736 3 12 3" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Edit & Favorite Part End !-->

                                    <!-- Description Part Start !-->
                                    <div class="mt-3 p-4 border border-slate-200 text-base-400 rounded">
                                        <p class="text-sm font-inter font-normal text-justify">
                                            {!! $ticket?->description !!}
                                        </p>
                                    </div>
                                    <!-- Description Part End !-->

                                    <!-- Attachment Part Start !-->
                                    <div class="flex justify-between items-center mt-3">
                                        <div class="flex items-center">
                                            <p class="text-base font-bold font-inter me-2">Attached File</p>
                                            <x-forms.input-file />
                                        </div>
                                        <div class="action flex">
                                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.2141 4.98239L17.6158 3.58063C18.39 2.80646 19.6452 2.80646 20.4194 3.58063C21.1935 4.3548 21.1935 5.60998 20.4194 6.38415L19.0176 7.78591M16.2141 4.98239L10.9802 10.2163C9.93493 11.2616 9.41226 11.7842 9.05637 12.4211C8.70047 13.058 8.3424 14.5619 8 16C9.43809 15.6576 10.942 15.2995 11.5789 14.9436C12.2158 14.5877 12.7384 14.0651 13.7837 13.0198L19.0176 7.78591M16.2141 4.98239L19.0176 7.78591" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M21 12C21 16.2426 21 18.364 19.682 19.682C18.364 21 16.2426 21 12 21C7.75736 21 5.63604 21 4.31802 19.682C3 18.364 3 16.2426 3 12C3 7.75736 3 5.63604 4.31802 4.31802C5.63604 3 7.75736 3 12 3" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Attachment Part End !-->

                                    <!-- Infos Part Start !-->
                                    <div class="mt-3 p-5 border border-slate-200 text-base-400 rounded">
                                        <div class="flex flex-wrap">
                                            <div class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3" style="border-right:2px solid #ddd">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Requester ID: </span>
                                                        <span class="font-sm font-normal font-inter">#{{ $ticket?->requester_id }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Request: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->user?->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Phone: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->user?->phone }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Email: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->user?->email }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Type: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->requester_type?->name }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3 sm:px-0 md:px-10 lg:px-10 sm:mt-3" style="border-right:2px solid #ddd">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Status: </span>
                                                        <span class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->ticket_status->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Priority: </span>
                                                        <span class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->priority }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Due Data: </span>
                                                        <span class="font-sm font-normal font-inter">{{ helper::ISODate($ticket?->due_date) }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Request Age: </span>
                                                        <span class="font-sm font-normal font-inter">{{ helper::humanReadableDate($ticket?->due_date) }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Category: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->category?->name }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3 sm:px-0 md:px-10 lg:px-10 sm:mt-3">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Assign Team: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->team->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Assign Agent: </span>
                                                        <span class="font-sm font-normal font-inter">{{ $ticket?->owners->pluck('name') }}</span>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Infos Part End !-->

                                    <!-- Edit Part Start !-->
                                    <div class="mt-3">
                                        <span class="text-base font-bold font-inter mb-2 inline-block">Edit Info</span>
                                        <form wire:submit="update">
                                            <div class="flex flex-row">
                                                <div class="md:basis-full sm:basis-full">
                                                    <div class="border border-slate-300 p-5 rounded">

                                                        <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="request_title" required="yes">
                                                                    {{ __('Request Title') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input wire:model="request_title" value="{{ $ticket?->title }}" type="text" />
                                                                <x-input-error :messages="$errors->get('request_title')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="grid md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-4">
                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="requester_name" required='yes'>
                                                                    {{ __('Requester Name') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input type="text" readonly wire:model='requester_name' value="{{ $ticket?->user->name }}" />
                                                                <x-input-error :messages="$errors->get('requester_name')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="requester_email" required="yes">
                                                                    {{ __('Requester Email') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input wire:model="requester_email" readonly type="email" value="{{ $ticket?->user->email }}" />
                                                                <x-input-error :messages="$errors->get('requester_email')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="requester_phone">
                                                                    {{ __('Requester Phone') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input type="number" readonly wire:model='requester_phone' value="{{ $ticket?->user->phone }}" />
                                                                <x-input-error :messages="$errors->get('requester_phone')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="grid md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-4">
                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="requester_type">
                                                                    {{ __('Requester Type') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="requester_type_id">
                                                                    <option selected value>Requester type</option>
                                                                    @foreach ($requester_type as $each)
                                                                    <option @selected(old('requester_type_id', $ticket?->requester_type_id) == $each?->id) value="{{ $each->id }}">{{ $each?->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('requester_type_id')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="due_date">
                                                                    {{ __('Due Date') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input type="date" wire:model='due_date' value="{{ $ticket?->due_date }}" />
                                                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="source_id">
                                                                    {{ __('Source') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="source_id">
                                                                    <option selected value>Source</option>
                                                                    @foreach ($sources as $each)
                                                                    <option @selected(old('source_id', $ticket?->source_id) == $each?->id) value="{{ $each->id }}">{{ $each?->title }}
                                                                    </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('source_id')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="grid md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-4">
                                                            <div class="p-2">
                                                                <x-forms.label for="category_id" required="yes">
                                                                    {{ __('Category') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="category_id">
                                                                    <option disabled value>Category</option>
                                                                    @foreach ($categories as $each)
                                                                    <option @selected(old('category_id', $ticket?->category_id) == $each?->id) value="{{ $each?->id }}">
                                                                        {{ $each?->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="ticket_status_id" required="yes">
                                                                    {{ __('Status') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="ticket_status_id">
                                                                    <option value="">Ticket status</option>
                                                                    @foreach ($ticket_status as $status)
                                                                    <option @selected(old('ticket_status_id', $ticket?->ticket_status_id) == $each?->id) value="{{ $status->id }}">{{ $status->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('ticket_status_id')" class="mt-2" />
                                                            </div>


                                                            <div class="p-2 w-full">
                                                                <x-forms.label for="priority" required="yes">
                                                                    {{ __('Requester Priority') }}
                                                                </x-forms.label>
                                                                <div class="mt-3">
                                                                    <x-forms.radio-input wire:model="priority" name="priority" class="ml-2" value="low" /> <span class="ml-2">Low</span>
                                                                    <x-forms.radio-input wire:model="priority" name="priority" class="ml-2" value="medium" /> <span class="ml-2">Medium</span>
                                                                    <x-forms.radio-input wire:model="priority" name="priority" class="ml-2" value="high" /> <span class="ml-2">High</span>
                                                                </div>
                                                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="team_id">
                                                                    {{ __('Assign Team') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="team_id">
                                                                    <option value="" disabled>Select a Team</option>
                                                                    @foreach ($teams as $each)
                                                                    <option value="{{ $each->id }}" @selected($each->team_id == $each->id)>{{ $each->name }}</option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                                                            </div>

                                                            <div class="p-2">
                                                                <x-forms.label for="owner_id">
                                                                    {{ __('Assign Agent') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input wire:model="owner_id">
                                                                    <option value="">Assign Agent</option>
                                                                    @foreach ($teamAgent as $each)
                                                                    @foreach ($each->agents as $item)
                                                                    <option {{ in_array($item->id, $ticket?->owners?->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $item?->id }}">
                                                                        {{ $item?->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div class="p-2">
                                                            <x-buttons.secondary type="button">
                                                                Cancel
                                                            </x-buttons.secondary>
                                                            <x-buttons.primary>
                                                                Update Ticket
                                                            </x-buttons.primary>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Edit Part End !-->

                                </div>
                                <div>
                                    Others part
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="tab-conversation">
                            Conversations Content is here..
                        </div>
                        <div class="hidden" id="tab-history">
                            History Content is here..
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('style')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
            /* Adjust the height to your preference */
        }
    </style>
    @endsection
    @section('script')
    <script type="text/javascript">
        function changeAtiveTab(event, tabID) {
            let element = event.target;
            while (element.nodeName !== "A") {
                element = element.parentNode;
            }
            ulElement = element.parentNode.parentNode;
            aElements = ulElement.querySelectorAll("li > a");
            tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");

            // Loop through all tabs and reset them to inactive styles
            for (let i = 0; i < aElements.length; i++) {
                aElements[i].classList.remove("text-white");
                aElements[i].classList.remove("bg-primary-400");
                aElements[i].classList.add("text-black-400");
                aElements[i].classList.add("bg-transparent");
                tabContents[i].classList.add("hidden");
                tabContents[i].classList.remove("block");
            }

            // Apply active styles to the clicked tab
            element.classList.remove("text-black-400");
            element.classList.remove("bg-transparent");
            element.classList.add("text-white");
            element.classList.add("bg-primary-400");

            // Show the corresponding content
            document.getElementById(tabID).classList.remove("hidden");
            document.getElementById(tabID).classList.add("block");
        }
    </script>
    <script>
        const editor = ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    this.set('request_description', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    @endsection


</x-app-layout>