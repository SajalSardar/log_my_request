<!-- Infos Part Start !-->
<div class="my-3 p-5 border border-slate-200 text-base-400 rounded">
    <div class="flex flex-wrap">
        <div class="basis-full sm:basis-full md:basis-1/2" style="border-right:2px solid #ddd">
            <ul>
                <li>
                    <span class="font-sm font-semibold font-inter">Requester ID:
                    </span>
                    <span class="font-sm font-normal font-inter">#{{ $ticket?->user->id }}</span>
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
                    <span class="font-sm font-normal font-inter">{{ $ticket?->user->requester_type?->name }}</span>
                </li>
            </ul>
        </div>
        <div class="basis-full sm:basis-full md:basis-1/2  sm:px-0 1 md:pl-10 lg:pl-6">
            <ul>
                <li>
                    <span class="font-sm font-semibold font-inter">Status: </span>
                    <span
                        class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->ticket_status->name }}</span>
                </li>
                <li>
                    <span class="font-sm font-semibold font-inter">Priority:
                    </span>
                    <span class="font-sm font-semibold font-inter text-red-600">{{ $ticket?->priority }}</span>
                </li>
                <li>
                    <span class="font-sm font-semibold font-inter">Due Data:
                    </span>
                    <span class="font-sm font-normal font-inter">{{ Helper::ISODate($ticket?->due_date) }}</span>
                </li>
                <li>
                    <span class="font-sm font-semibold font-inter">Category:
                    </span>
                    <span class="font-sm font-normal font-inter">{{ $ticket?->category?->name }}</span>
                </li>
                <li>
                    <span class="font-sm font-semibold font-inter">Request Age:
                    </span>
                    <span
                        class="font-sm font-normal font-inter">{{ Helper::dayMonthYearHourMininteSecond($ticket?->created_at, true, true, true, true) }}</span>
                </li>
            </ul>
        </div>
        {{-- <div
            class="basis-full sm:basis-full md:basis-1/3 lg:basis-1/3 sm:px-0 md:px-10 lg:px-4">
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
                        class="font-sm font-normal font-inter">{{ count($ticket->owners) > 0 ? $ticket->owners->last()->name : '-' }}</span>
                </li>

            </ul>
        </div> --}}
    </div>

</div>
<!-- Infos Part End !-->

<!-- Edit & Favorite Part Start !-->
<div class="flex justify-between">
    <p class="text-base font-bold font-inter">Request Description</p>
    <div class="action flex">
        <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M16.2141 4.98239L17.6158 3.58063C18.39 2.80646 19.6452 2.80646 20.4194 3.58063C21.1935 4.3548 21.1935 5.60998 20.4194 6.38415L19.0176 7.78591M16.2141 4.98239L10.9802 10.2163C9.93493 11.2616 9.41226 11.7842 9.05637 12.4211C8.70047 13.058 8.3424 14.5619 8 16C9.43809 15.6576 10.942 15.2995 11.5789 14.9436C12.2158 14.5877 12.7384 14.0651 13.7837 13.0198L19.0176 7.78591M16.2141 4.98239L19.0176 7.78591"
                stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M21 12C21 16.2426 21 18.364 19.682 19.682C18.364 21 16.2426 21 12 21C7.75736 21 5.63604 21 4.31802 19.682C3 18.364 3 16.2426 3 12C3 7.75736 3 5.63604 4.31802 4.31802C5.63604 3 7.75736 3 12 3"
                stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
        </svg>

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z"
                stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 17H16" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8 13H12" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M13 2.5V3C13 5.82843 13 7.24264 13.8787 8.12132C14.7574 9 16.1716 9 19 9H19.5M20 10.6569V14C20 17.7712 20 19.6569 18.8284 20.8284C17.6569 22 15.7712 22 12 22C8.22876 22 6.34315 22 5.17157 20.8284C4 19.6569 4 17.7712 4 14V9.45584C4 6.21082 4 4.58831 4.88607 3.48933C5.06508 3.26731 5.26731 3.06508 5.48933 2.88607C6.58831 2 8.21082 2 11.4558 2C12.1614 2 12.5141 2 12.8372 2.11401C12.9044 2.13772 12.9702 2.165 13.0345 2.19575C13.3436 2.34355 13.593 2.593 14.0919 3.09188L18.8284 7.82843C19.4065 8.40649 19.6955 8.69552 19.8478 9.06306C20 9.4306 20 9.83935 20 10.6569Z"
                                stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <div class="info">
                        <p class="text-sm font-inter font-normal">Doc File</p>
                        <p class="text-sm font-inter font-normal">3 MB</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <svg width="30" height="30" viewBox="0 0 24 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 20.5H18" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M12 16.5V4.5" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M16 12.5C16 12.5 13.054 16.5 12 16.5C10.9459 16.5 8 12.5 8 12.5" stroke="#666666"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </a>

            <a href="#" style="width: 200px;" download
                class="flex justify-between px-1 py-1 border border-slate-300 rounded bg-gray-200">
                <div class="flex items-center">
                    <span class="pr-1">
                        <svg width="30" height="30" viewBox="0 0 24 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19 11.5C19 10.6825 19 9.9306 18.8478 9.56306C18.6955 9.19552 18.4065 8.90649 17.8284 8.32843L13.0919 3.59188C12.593 3.093 12.3436 2.84355 12.0345 2.69575C11.9702 2.665 11.9044 2.63772 11.8372 2.61401C11.5141 2.5 11.1614 2.5 10.4558 2.5C7.21082 2.5 5.58831 2.5 4.48933 3.38607C4.26731 3.56508 4.06508 3.76731 3.88607 3.98933C3 5.08831 3 6.71082 3 9.95584V14.5C3 18.2712 3 20.1569 4.17157 21.3284C5.34315 22.5 7.22876 22.5 11 22.5H19M12 3V3.5C12 6.32843 12 7.74264 12.8787 8.62132C13.7574 9.5 15.1716 9.5 18 9.5H18.5"
                                stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M21 14.5H19C18.4477 14.5 18 14.9477 18 15.5V17M18 17V19.5M18 17H20.5M7 19.5V17.5M7 17.5V14.5H8.5C9.32843 14.5 10 15.1716 10 16C10 16.8284 9.32843 17.5 8.5 17.5H7ZM12.5 14.5H13.7857C14.7325 14.5 15.5 15.2462 15.5 16.1667V17.8333C15.5 18.7538 14.7325 19.5 13.7857 19.5H12.5V14.5Z"
                                stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </span>
                    <div class="info">
                        <p class="text-sm font-inter font-normal">PDF File</p>
                        <p class="text-sm font-inter font-normal">3 MB</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <svg width="30" height="30" viewBox="0 0 24 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 20.5H18" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M12 16.5V4.5" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M16 12.5C16 12.5 13.054 16.5 12 16.5C10.9459 16.5 8 12.5 8 12.5" stroke="#666666"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </a>
        </div>

    </div>
</div>
<!-- Attachment Part End !-->
