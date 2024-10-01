<x-app-layout>
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
                    <span class="text-sm font-inter font-thin text-teal-500">{{ $ticket?->priority }}</span>
                    <p class="md:hidden sm:block font-inter font-thin text-sm inline-block">Due Date:</p>
                    <span class="md:hidden text-sm font-inter font-semibold">{{ Helper::ISODate($ticket?->due_date) }}</span>
                </div>
                <div class="left sm:hidden md:block text-end">
                    <p class="font-inter font-thin text-sm">Due Date: </p>
                    <span class="text-sm font-inter font-semibold"> {{ Helper::ISODate($ticket?->due_date) }}</span>
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
