<x-app-layout>
    <header class="mb-6">
        <span class="text-base font-bold font-inter">Request ID & Title: {{ $ticket?->requester_id }} ,
            {{ $ticket?->title }}</span>
    </header>

    <div class="flex flex-wrap" id="tabs-id">
        <div class="w-full">
            <ul class="flex mb-0 list-none bg-[#F3F4F6]">
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-primary-400 text-white"
                        onclick="changeAtiveTab(event,'tab-detail')">
                        <i class="fas fa-space-shuttle text-base mr-1"></i> Details
                    </a>
                </li>
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400"
                        onclick="changeAtiveTab(event,'tab-conversation')">
                        <i class="fas fa-cog text-base mr-1"></i> Conversations
                    </a>
                </li>
                <li class="-mb-px last:mr-0 px-5 text-center">
                    <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400"
                        onclick="changeAtiveTab(event,'tab-history')">
                        <i class="fas fa-briefcase text-base mr-1"></i> History
                    </a>
                </li>
            </ul>

            <div class="relative flex flex-col min-w-0 break-words bg-white w-full my-6">
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <div class="block" id="tab-detail">
                            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-5">
                                <div class="col-span-2">
                                    <!-- Infos Part Start !-->
                                    <div class="my-3 p-5 border border-slate-200 text-base-400 rounded">
                                        <div class="flex flex-wrap">
                                            <div class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3"
                                                style="border-right:2px solid #ddd">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Requester ID:
                                                        </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">#{{ $ticket?->requester_id }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Request: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->user?->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Phone: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->user?->phone }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Email: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->user?->email }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Type: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->requester_type?->name }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3 sm:px-0 md:px-10 lg:px-10 sm:mt-3"
                                                style="border-right:2px solid #ddd">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Status: </span>
                                                        <span
                                                            class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->ticket_status->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Priority: </span>
                                                        <span
                                                            class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->priority }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Due Data: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ Helper::ISODate($ticket?->due_date) }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Request Age:
                                                        </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ Helper::dayMonthYearHourMininteSecond($ticket?->created_at, true, true, true, true, true, true) }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Category: </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->category?->name }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div
                                                class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3 sm:px-0 md:px-10 lg:px-10 sm:mt-3">
                                                <ul>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Assign Team:
                                                        </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ @$ticket?->team->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-sm font-semibold font-inter">Assign Agent:
                                                        </span>
                                                        <span
                                                            class="font-sm font-normal font-inter">{{ $ticket?->owners->pluck('name') }}</span>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Infos Part End !-->

                                    <!-- Edit & Favorite Part Start !-->
                                    <div class="flex justify-between">
                                        <p class="text-base font-bold font-inter">Request Description</p>
                                        <div class="action flex">
                                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16.2141 4.98239L17.6158 3.58063C18.39 2.80646 19.6452 2.80646 20.4194 3.58063C21.1935 4.3548 21.1935 5.60998 20.4194 6.38415L19.0176 7.78591M16.2141 4.98239L10.9802 10.2163C9.93493 11.2616 9.41226 11.7842 9.05637 12.4211C8.70047 13.058 8.3424 14.5619 8 16C9.43809 15.6576 10.942 15.2995 11.5789 14.9436C12.2158 14.5877 12.7384 14.0651 13.7837 13.0198L19.0176 7.78591M16.2141 4.98239L19.0176 7.78591"
                                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M21 12C21 16.2426 21 18.364 19.682 19.682C18.364 21 16.2426 21 12 21C7.75736 21 5.63604 21 4.31802 19.682C3 18.364 3 16.2426 3 12C3 7.75736 3 5.63604 4.31802 4.31802C5.63604 3 7.75736 3 12 3"
                                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z"
                                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
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
                                    <div class="flex items-center mt-3">
                                        <div class="flex items-center">
                                            <p class="text-base font-bold font-inter me-2">Attached File:</p>
                                            <div class="custom_file flex gap-5">
                                                <a href="#" style="width: 200px;" download
                                                    class="flex justify-between px-1 py-1 border border-slate-300 rounded bg-gray-200">
                                                    <div class="flex items-center">
                                                        <span class="pr-1">
                                                            <svg width="30" height="30" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8 17H16" stroke="#333333" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M8 13H12" stroke="#333333" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M13 2.5V3C13 5.82843 13 7.24264 13.8787 8.12132C14.7574 9 16.1716 9 19 9H19.5M20 10.6569V14C20 17.7712 20 19.6569 18.8284 20.8284C17.6569 22 15.7712 22 12 22C8.22876 22 6.34315 22 5.17157 20.8284C4 19.6569 4 17.7712 4 14V9.45584C4 6.21082 4 4.58831 4.88607 3.48933C5.06508 3.26731 5.26731 3.06508 5.48933 2.88607C6.58831 2 8.21082 2 11.4558 2C12.1614 2 12.5141 2 12.8372 2.11401C12.9044 2.13772 12.9702 2.165 13.0345 2.19575C13.3436 2.34355 13.593 2.593 14.0919 3.09188L18.8284 7.82843C19.4065 8.40649 19.6955 8.69552 19.8478 9.06306C20 9.4306 20 9.83935 20 10.6569Z"
                                                                    stroke="#333333" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <div class="info">
                                                            <p class="text-sm font-inter font-normal">Doc File</p>
                                                            <p class="text-sm font-inter font-normal">3 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <svg width="30" height="30" viewBox="0 0 24 25"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 20.5H18" stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" />
                                                            <path d="M12 16.5V4.5" stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path
                                                                d="M16 12.5C16 12.5 13.054 16.5 12 16.5C10.9459 16.5 8 12.5 8 12.5"
                                                                stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </a>

                                                <a href="#" style="width: 200px;" download
                                                    class="flex justify-between px-1 py-1 border border-slate-300 rounded bg-gray-200">
                                                    <div class="flex items-center">
                                                        <span class="pr-1">
                                                            <svg width="30" height="30" viewBox="0 0 24 25"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M19 11.5C19 10.6825 19 9.9306 18.8478 9.56306C18.6955 9.19552 18.4065 8.90649 17.8284 8.32843L13.0919 3.59188C12.593 3.093 12.3436 2.84355 12.0345 2.69575C11.9702 2.665 11.9044 2.63772 11.8372 2.61401C11.5141 2.5 11.1614 2.5 10.4558 2.5C7.21082 2.5 5.58831 2.5 4.48933 3.38607C4.26731 3.56508 4.06508 3.76731 3.88607 3.98933C3 5.08831 3 6.71082 3 9.95584V14.5C3 18.2712 3 20.1569 4.17157 21.3284C5.34315 22.5 7.22876 22.5 11 22.5H19M12 3V3.5C12 6.32843 12 7.74264 12.8787 8.62132C13.7574 9.5 15.1716 9.5 18 9.5H18.5"
                                                                    stroke="#333333" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M21 14.5H19C18.4477 14.5 18 14.9477 18 15.5V17M18 17V19.5M18 17H20.5M7 19.5V17.5M7 17.5V14.5H8.5C9.32843 14.5 10 15.1716 10 16C10 16.8284 9.32843 17.5 8.5 17.5H7ZM12.5 14.5H13.7857C14.7325 14.5 15.5 15.2462 15.5 16.1667V17.8333C15.5 18.7538 14.7325 19.5 13.7857 19.5H12.5V14.5Z"
                                                                    stroke="#333333" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>

                                                        </span>
                                                        <div class="info">
                                                            <p class="text-sm font-inter font-normal">PDF File</p>
                                                            <p class="text-sm font-inter font-normal">3 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <svg width="30" height="30" viewBox="0 0 24 25"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 20.5H18" stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" />
                                                            <path d="M12 16.5V4.5" stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path
                                                                d="M16 12.5C16 12.5 13.054 16.5 12 16.5C10.9459 16.5 8 12.5 8 12.5"
                                                                stroke="#666666" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Attachment Part End !-->

                                    <!-- Notes Part Start !-->
                                    <div class="flex justify-between">
                                        <button
                                            class="px-3 py-1 text-base-400 bg-[#FFF4EC] rounded-sm text-base font-semibold font-inter">
                                            Notes
                                        </button>
                                    </div>
                                    <div class="mt-3 p-4 border border-slate-200">
                                        <div class="flex">
                                            <div class="flex items-center">
                                                <img src="{{ asset('assets/images/user.png') }}" alt="profile">
                                            </div>
                                            <div class="mt-5 pl-2">
                                                <p class="text-base font-semibold font-inter">Md. Shah Alam</p>
                                                <p class="text-base font-normal font-inter ">Added a private note one
                                                    week ago (Monday,17 Oct, 2024 3:45pm)</p>
                                                <p class="text-base font-normal font-inter ">-Requested details of
                                                    financial aid applications</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end p-3">
                                        <button>
                                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z"
                                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.5 10C3.5 6.70017 3.5 5.05025 4.52513 4.02513C5.55025 3 7.20017 3 10.5 3H13.5C16.7998 3 18.4497 3 19.4749 4.02513C20.5 5.05025 20.5 6.70017 20.5 10V15C20.5 18.2998 20.5 19.9497 19.4749 20.9749C18.4497 22 16.7998 22 13.5 22H10.5C7.20017 22 5.55025 22 4.52513 20.9749C3.5 19.9497 3.5 18.2998 3.5 15V10Z"
                                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M8 15H12M8 10H16" stroke="#666666" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Notes Part End !-->


                                </div>

                                <div>
                                    <!-- Edit Part Start !-->
                                    <div class="mt-3">
                                        <form wire:submit="update">
                                            <div class="flex flex-row">
                                                <div class="md:basis-full sm:basis-full">
                                                    <div class="border border-slate-300 p-5 rounded">

                                                        <div
                                                            class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-3">
                                                            <div class="p-2">
                                                                <x-forms.label for="form.due_date">
                                                                    {{ __('Due Date') }}
                                                                </x-forms.label>
                                                                <x-forms.text-input type="date"
                                                                    name='form.due_date'
                                                                    value="{{ $ticket?->due_date }}" />
                                                                <x-input-error :messages="$errors->get('form.due_date')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="source_id">
                                                                    {{ __('Source') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input name="source_id">
                                                                    <option selected value>Source</option>
                                                                    @foreach ($sources as $each)
                                                                        <option @selected(old('source_id', $ticket?->source_id) == $each?->id)
                                                                            value="{{ $each->id }}">
                                                                            {{ $each?->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('source_id')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="grid md:grid-cols-2 sm:grid-cols-2 sm:gap-1 md:gap-3">
                                                            <div class="p-2">
                                                                <x-forms.label for="category_id" required="yes">
                                                                    {{ __('Category') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input name="category_id">
                                                                    <option disabled value>Category</option>
                                                                    @foreach ($categories as $each)
                                                                        <option @selected(old('category_id', $ticket?->category_id) == $each?->id)
                                                                            value="{{ $each?->id }}">
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

                                                                <x-forms.select-input name="ticket_status_id">
                                                                    <option value="">Ticket status</option>
                                                                    @foreach ($ticket_status as $status)
                                                                        <option @selected(old('ticket_status_id', $ticket?->ticket_status_id) == $status?->id)
                                                                            value="{{ $status->id }}">
                                                                            {{ $status->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('ticket_status_id')" class="mt-2" />
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="grid md:grid-cols-2 sm:grid-cols-2 sm:gap-1 md:gap-3">
                                                            <div class="p-2">
                                                                <x-forms.label for="team_id">
                                                                    {{ __('Assign Team') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input name="team_id" id="team">
                                                                    <option value="" disabled>Select a Team
                                                                    </option>
                                                                    @foreach ($teams as $each)
                                                                        <option value="{{ $each->id }}"
                                                                            @selected($each->team_id == $each->id)>
                                                                            {{ $each->name }}</option>
                                                                    @endforeach
                                                                </x-forms.select-input>

                                                                <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                                                            </div>
                                                            <div class="p-2">
                                                                <x-forms.label for="owner_id">
                                                                    {{ __('Assign Agent') }}
                                                                </x-forms.label>

                                                                <x-forms.select-input name="owner_id">
                                                                    <option value="">Assign Agent</option>
                                                                    @foreach ($agents as $each)
                                                                        @foreach ($each->agents as $item)
                                                                            <option
                                                                                {{ in_array($item->id, $ticket?->owners?->pluck('id')->toArray()) ? 'selected' : '' }}
                                                                                value="{{ $item?->id }}">
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
                                                                Update
                                                            </x-buttons.primary>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Edit Part End !-->

                                    <div class="mt-3">
                                        <p class="text-base font-bold font-inter">Open Requests</p>
                                        <table class="w-full mt-3">
                                            <thead class="w-full bg-[#F3F4F6] mb-5 rounded">
                                                <tr>
                                                    <th class="text-start p-2 flex items-center">
                                                        <span>
                                                            <svg width="20" height="20" viewBox="0 0 20 20"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M2.5 5H4.16667H17.5" stroke="#666666"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path
                                                                    d="M15.8332 5.00008V16.6667C15.8332 17.1088 15.6576 17.5327 15.345 17.8453C15.0325 18.1578 14.6085 18.3334 14.1665 18.3334H5.83317C5.39114 18.3334 4.96722 18.1578 4.65466 17.8453C4.3421 17.5327 4.1665 17.1088 4.1665 16.6667V5.00008M6.6665 5.00008V3.33341C6.6665 2.89139 6.8421 2.46746 7.15466 2.1549C7.46722 1.84234 7.89114 1.66675 8.33317 1.66675H11.6665C12.1085 1.66675 12.5325 1.84234 12.845 2.1549C13.1576 2.46746 13.3332 2.89139 13.3332 3.33341V5.00008"
                                                                    stroke="#666666" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M8.3335 9.16675V14.1667" stroke="#666666"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M11.6665 9.16675V14.1667" stroke="#666666"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <span class="ms-1">Select</span>
                                                    </th>
                                                    <th class="text-start p-2">ID</th>
                                                    <th class="text-start p-2">Title</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr style="border:1px solid #DDDDDD">
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            <x-forms.checkbox-input />
                                                        </span>
                                                    </td>
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            #{{ $ticket?->id }}
                                                        </span>
                                                    </td>
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            {{ Str::limit($ticket?->title, 30, '...') }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr style="border:1px solid #DDDDDD">
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            <x-forms.checkbox-input />
                                                        </span>
                                                    </td>
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            #{{ $ticket?->id }}
                                                        </span>
                                                    </td>
                                                    <td class="p-2">
                                                        <span class="font-inter font-normal text-slate-500 text-sm">
                                                            {{ Str::limit($ticket?->title, 30, '...') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        <script>
            let team = document.querySelector('#team');
            team.addEventListener('change', function(e) {
                let team_id = e.target.value;
                let ticket_id = '@json($ticket->id)';
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.ticket.show', ['ticket' => '__TICKET_ID__']) }}".replace(
                        '__TICKET_ID__', ticket_id),
                    dataType: 'json',
                    data: {
                        team_id: team_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let ownerSelect = $('select[name="owner_id"]');
                        ownerSelect.find('option:not(:first)').remove();
                        response.forEach(element => {
                            element.agents.forEach(e => {
                                ownerSelect.append(new Option(e.name, e.id));
                            })
                        });
                    }
                });
            });
        </script>


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
