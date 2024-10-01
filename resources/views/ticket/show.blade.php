<x-app-layout>
    {{-- <div class="grid sm:grid-cols-1 md:grid-cols-2 md:gap-1 sm:gap-1">
        <div class="border border-slate-300 px-5 py-10 rounded">
            <div class="grid md:grid-cols-1 sm:grid-cols-1 border border-slate-300 px-10 py-3 rounded">
                <div class="grid sm:grid-cols-2 md:grid-cols-2 md:gap-1 sm:gap-1">
                    <div class="left">
                        <div class="flex">
                            <div class="pr-3">
                                <img src="https://i.pravatar.cc/300/10" alt="img" height="50" width="50" style="border-radius: 50%">
                            </div>

                            <div class="content">
                                <h3 class="font-inter font-bold text-sm">Albert Adrose</h3>
                                <ul>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Requester ID: </p>
                                        <span class="text-sm font-inter font-thin"> #12546856</span>
                                    </li>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Phone: </p>
                                        <span class="text-sm font-inter font-thin"> 0179567896</span>
                                    </li>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Email: </p>
                                        <span class="text-sm font-inter font-thin"> thealamdev@gmail.com</span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="right">
                        <p class="font-ineter font-semibold text-sm inline-block">Title : </p> <span class="font-inter font-thin text-sm"> Delays or errors in processing financial aid applications, grants, or scholarships</span>
                    </div>
                </div>

                <div class="mt-3 bg-[#F8F8F8] px-8 py-5 rounded text-justify">
                    <p class="font-ineter font-semibold text-sm inline-block">Request Description:</p> <span class="font-inter font-thin text-sm">Request Description: This issue pertains to problems students encounter when applying for or receiving financial aid, grants, or scholarships from their educational institution. Delays or errors in the processing of these applications can cause significant stress and hardship for students.</span>
                </div>
            </div>

            <div class="grid md:grid-cols-1 sm:grid-cols-1 border border-slate-300 px-10 py-3 rounded mt-5">
                <div class="relative overflow-x-auto">
                    <table class="w-full overflow-x-auto">
                        <tr>
                            <td>
                                <p class="font-ineter font-thin text-sm">Attached File</p>
                                <x-forms.input-file />
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Priority</p>
                                <span class="font-ineter font-semibold text-sm">High</span>
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Due Date</p>
                                <span class="font-ineter font-semibold text-sm">17 Aug, 2017</span>
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Soure</p>
                                <span class="font-ineter font-semibold text-sm">Website</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="font-ineter font-thin text-sm">Category</p>
                                <span class="font-ineter font-semibold text-sm">Financial</span>
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Assign Team</p>
                                <span class="font-ineter font-semibold text-sm">Finance</span>
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Requester Type</p>
                                <span class="font-ineter font-semibold text-sm">Student</span>
                            </td>
                            <td>
                                <p class="font-ineter font-thin text-sm">Assign Agent</p>
                                <span class="font-ineter font-semibold text-sm">Finance</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="font-ineter font-thin text-sm">Status</p>
                                <span class="font-ineter font-semibold text-sm">Open</span>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div> --}}

    <div class="grid sm:grid-cols-1 md:grid-cols-2 md:gap-1 sm:gap-1">
        <div class="border border-slate-300 px-5 py-10 rounded">
            <div class="grid sm:grid-cols-3 md:grid-cols-4 md:gap-1 sm:gap-1">
                <div class="left sm:col-span-2 md:col-span-2">
                    <div class="flex">
                        <div class="pr-3">
                            <img src="https://i.pravatar.cc/300/10" alt="img" height="50" width="50" style="border-radius: 50%">
                        </div>

                        <div class="content">
                            <h3 class="font-inter font-bold text-sm">{{ $ticket?->user?->name }}</h3>
                            <ul>
                                <li>
                                    <p class="font-inter font-semibold text-sm inline-block">Requester ID: </p>
                                    <span class="text-sm font-inter font-thin">#{{ $ticket?->requester_id }}</span>
                                </li>
                                <li>
                                    <p class="font-inter font-semibold text-sm inline-block">Phone: </p>
                                    <span class="text-sm font-inter font-thin">{{ $ticket->user?->phone }}</span>
                                </li>
                                <li>
                                    <p class="font-inter font-semibold text-sm inline-block">Email: </p>
                                    <span class="text-sm font-inter font-thin">{{ $ticket->user?->email }}</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="left text-end">
                    <p class="font-inter font-semibold text-sm inline-block">Priority: </p>
                    <span class="text-sm font-inter font-thin text-teal-500">High</span>
                    <p class="md:hidden sm:block font-inter font-thin text-sm inline-block">Due Date:</p>
                    <span class="md:hidden text-sm font-inter font-semibold">17 Aug, 2024</span>
                </div>
                <div class="left sm:hidden md:block text-end">
                    <p class="font-inter font-thin text-sm">Due Date: </p>
                    <span class="text-sm font-inter font-semibold">17 Aug, 2024</span>
                </div>
            </div>

            <div class="mt-1">
                <p class="font-inter font-semibold text-sm inline-block">Title: </p>
                <span class="font-inter font-semibold text-sm">{{ $ticket?->title }}</span>
            </div>

            <div class="mt-2">
                <p class="font-inter font-semibold text-xs inline-block">Description: </p>
                <span class="font-inter font-normal text-xs">{!! $ticket?->description !!}</span>
            </div>

            <div class="mt-2">
                <ul>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Requester Type: </p>
                        <span class="font-inter font-semibold text-xs">{{ $ticket?->requester_type->name ?? '--' }}</span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Category: </p>
                        <span class="font-inter font-semibold text-xs">{{ $ticket?->category?->name ?? '--' }}</span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Assigned Agent: </p>
                        <span class="font-inter font-semibold text-xs">{{ 'Finance' }}</span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Assigned Team: </p>
                        <span class="font-inter font-semibold text-xs">{{ $ticket?->team?->name ?? '--' }}</span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Source: </p>
                        <span class="font-inter font-semibold text-xs">{{ $ticket?->source?->name ?? '--' }}</span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Statuc: </p>
                        <span class="font-inter font-semibold text-xs {{ $ticket?->ticket_status?->name == 'In process' ? 'text-process-400' : ($ticket?->ticket_status?->name == 'open' ? 'text-open-400' : '') }}">
                            {{ $ticket?->ticket_status?->name ?? '--' }}
                        </span>
                    </li>
                    <li>
                        <p class="font-inter font-normal text-xs inline-block">Attach File: </p>
                        <span class="font-inter font-semibold text-xs inline-block">
                            <x-forms.input-file />
                        </span>
                    </li>
                </ul>

            </div>

        </div>
    </div>





</x-app-layout>
