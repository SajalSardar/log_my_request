<x-app-layout>
    <header class="flex justify-center">
        <div>
            {{-- <x-forms.text-input-icon dir="left" placeholder="Search here">
                <!-- SVG for search -->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.0004 20.9999L16.6504 16.6499" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-forms.text-input-icon> --}}
        </div>
    </header>

    <div class="relative overflow-x-auto">
        <div class="text-black font-inter font-semibold py-3" style="cursor: pointer;border-bottom:1px solid #dadada"
            onclick="toggleSubmenu(this)">
            <div class="flex justify-between">
                <div class="status_count flex items-center">
                    <span>{{ __(ucfirst('Unassign Request')) }}
                        {{ '(' . count($unassignTicket) . ')' }}</span>
                    <span class="pl-2 arrow">
                        <!-- Arrow down -->
                        <svg width="15" height="5" viewBox="0 0 15 5" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L5 5L10 0H0Z" fill="#666666" />
                        </svg>
                    </span>
                </div>
                <div class="status">
                    <a href="{{ route('admin.ticket.status.wise.list', ['ticket_status' => 'unassign']) }}"
                        class="border border-slate-300 rounded font-inter font-normal px-2 py-1">View
                        All</a>
                </div>
            </div>
        </div>
        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start p-2" style="max-width: 70px">ID</th>
                    <th class="text-start p-2" style="width: 200px">Title</th>
                    <th class="text-start p-2" style="max-width: 80px">Priority</th>
                    <th class="text-start p-2" style="max-width: 130px">Status</th>
                    <th class="text-start p-2" style="max-width: 210px">Requester Name</th>
                    <th class="text-start p-2" style="max-width: 150px">Requester Type</th>
                    <th class="text-start p-2" style="max-width: 130px">Assigned Team</th>
                    <th class="text-start p-2" style="max-width: 140px">Assigned Agent</th>
                    <th class="text-start p-2" style="max-width: 120px">Created Date</th>
                    <th class="text-start p-2">Source</th>
                    <th class="text-start p-2">Due Date</th>
                    <th class="text-start p-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unassignTicket as $ticket)
                    <tr>
                        <td class="p-2">
                            <span class="font-inter font-normal text-slate-500 text-sm">
                                #{{ $ticket?->id }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            <span class="font-inter font-normal text-slate-500 text-sm">
                                {{ $ticket?->title }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            <span
                                class="text-{{ $ticket?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-bold">
                                {{ $ticket?->priority }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            @if (strtolower(trim($ticket->ticket_status->name)) === 'in progress')
                                <x-buttons.primary class="!px-2 font-inter font-bold bg-process-400">
                                    {{ $ticket->ticket_status->name }}
                                </x-buttons.primary>
                            @elseif (strtolower(trim($ticket->ticket_status->name)) === 'open')
                                <x-buttons.primary class="font-inter font-bold !bg-open-400">
                                    {{ $ticket->ticket_status->name }}
                                </x-buttons.primary>
                            @elseif (strtolower(trim($ticket->ticket_status->name)) === 'on hold')
                                <x-buttons.primary class="font-inter font-bold !bg-hold-400">
                                    {{ $ticket->ticket_status->name }}
                                </x-buttons.primary>
                            @endif

                        </td>

                        <td class="p-2 font-normal text-gray-400 flex items-center" style="max-width: 210px">
                            <img src="https://i.pravatar.cc/300/5" alt="img" width="50" height="50"
                                style="border-radius: 50%">
                            <span class="ml-2">
                                {{ $ticket?->user->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 150px">
                            <span class="font-normal text-gray-400">
                                {{ $ticket?->requester_type?->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 130px">
                            <span class="font-normal text-gray-400">
                                {{ $ticket?->team?->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 140px">
                            <span class="font-normal text-gray-400">
                                @foreach ($ticket?->owners as $agent)
                                    {{ $agent?->name }}
                                @endforeach
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 120px">
                            <span class="font-normal text-gray-400">{{ Helper::ISODate($ticket?->created_at) }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ $ticket?->source?->title }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">17 Oct, 2024</span>
                        </td>
                        <td class="relative">
                            <button onclick="toggleAction({{ $ticket->id }})"
                                class="p-3 hover:bg-slate-100 rounded-full">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <div id="action-{{ $ticket->id }}" class="shadow-lg z-30 absolute top-5 right-16"
                                style="display: none">
                                <ul>
                                    <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                        <a href="{{ route('admin.ticket.edit', ['ticket' => $ticket?->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-white">
                                        <a
                                            href="{{ route('admin.ticket.show', ['ticket' => $ticket?->id]) }}">View</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-red-600 text-white">
                                        <a href="#">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">
                            <span class="text-red-500 font-inter font-bold text-lg">No data found !!</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto">

        @forelse ($tickets as $each)
            @if ($each->name)
                <div class="main-row text-black font-inter font-semibold py-3"
                    style="cursor: pointer;border-bottom:1px solid #dadada" onclick="toggleSubmenu(this)">

                    <div class="flex justify-between">
                        <div class="status_count flex items-center">
                            <span>{{ ucfirst($each?->name) . ' Request' }}
                                {{ '(' . count($each?->ticket) . ')' }}</span>
                            <span class="pl-2 arrow">
                                <!-- Arrow down -->
                                <svg width="15" height="5" viewBox="0 0 15 5" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0L5 5L10 0H0Z" fill="#666666" />
                                </svg>
                            </span>
                        </div>
                        <div class="status">
                            <a href="{{ route('admin.ticket.status.wise.list', ['ticket_status' => $each?->slug]) }}"
                                class="border border-slate-300 rounded font-inter font-normal px-2 py-1">View
                                All</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="rounded shadow submenu" style="display: table-row;">
                <table class="w-full overflow-x-auto">
                    <thead class="w-full bg-slate-100 mb-5">
                        <tr>
                            <th class="text-start p-2" style="max-width: 70px">ID</th>
                            <th class="text-start p-2" style="width: 200px">Title</th>
                            <th class="text-start p-2" style="max-width: 80px">Priority</th>
                            <th class="text-start p-2" style="max-width: 130px">Status</th>
                            <th class="text-start p-2" style="max-width: 210px">Requester Name</th>
                            <th class="text-start p-2" style="max-width: 150px">Requester Type</th>
                            <th class="text-start p-2" style="max-width: 130px">Assigned Team</th>
                            <th class="text-start p-2" style="max-width: 140px">Assigned Agent</th>
                            <th class="text-start p-2" style="max-width: 120px">Created Date</th>
                            <th class="text-start p-2">Source</th>
                            <th class="text-start p-2">Due Date</th>
                            <th class="text-start p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($each?->ticket as $ticket)
                            <tr>
                                <td class="p-2">
                                    <span class="font-inter font-normal text-slate-500 text-sm">
                                        #{{ $ticket?->id }}
                                    </span>
                                </td>
                                <td class="p-2 font-normal text-gray-400">
                                    <span class="font-inter font-normal text-slate-500 text-sm">
                                        {{ $ticket?->title }}
                                    </span>
                                </td>
                                <td class="p-2 font-normal text-gray-400">
                                    <span
                                        class="text-{{ $ticket?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-bold">
                                        {{ $ticket?->priority }}
                                    </span>
                                </td>
                                <td class="p-2 font-normal text-gray-400">
                                    @if (strtolower(trim($each->name)) === 'in progress')
                                        <x-buttons.primary class="!px-2 font-inter font-bold bg-process-400">
                                            {{ $each->name }}
                                        </x-buttons.primary>
                                    @elseif (strtolower(trim($each->name)) === 'open')
                                        <x-buttons.primary class="font-inter font-bold !bg-open-400">
                                            {{ $each->name }}
                                        </x-buttons.primary>
                                    @elseif (strtolower(trim($each->name)) === 'on hold')
                                        <x-buttons.primary class="font-inter font-bold !bg-hold-400">
                                            {{ $each->name }}
                                        </x-buttons.primary>
                                    @endif

                                </td>

                                <td class="p-2 font-normal text-gray-400 flex items-center" style="max-width: 210px">
                                    <img src="https://i.pravatar.cc/300/5" alt="img" width="50"
                                        height="50" style="border-radius: 50%">
                                    <span class="ml-2">
                                        {{ $ticket?->user->name }}
                                    </span>
                                </td>
                                <td class="p-2" style="max-width: 150px">
                                    <span class="font-normal text-gray-400">
                                        {{ $ticket?->requester_type?->name }}
                                    </span>
                                </td>
                                <td class="p-2" style="max-width: 130px">
                                    <span class="font-normal text-gray-400">
                                        {{ $ticket?->team?->name }}
                                    </span>
                                </td>
                                <td class="p-2" style="max-width: 140px">
                                    <span class="font-normal text-gray-400">
                                        @foreach ($ticket?->owners as $agent)
                                            {{ $agent?->name }}
                                        @endforeach
                                    </span>
                                </td>
                                <td class="p-2" style="max-width: 120px">
                                    <span
                                        class="font-normal text-gray-400">{{ Helper::ISODate($ticket?->created_at) }}</span>
                                </td>
                                <td class="p-2">
                                    <span class="font-normal text-gray-400">{{ $ticket?->source?->title }}</span>
                                </td>
                                <td class="p-2">
                                    <span class="font-normal text-gray-400">17 Oct, 2024</span>
                                </td>
                                <td class="relative">
                                    <button onclick="toggleAction({{ $ticket->id }})"
                                        class="p-3 hover:bg-slate-100 rounded-full">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <div id="action-{{ $ticket->id }}"
                                        class="shadow-lg z-30 absolute top-5 right-16" style="display: none">
                                        <ul>
                                            <li class="px-5 py-1 text-center"
                                                style="background: #FFF4EC;color:#F36D00">
                                                <a
                                                    href="{{ route('admin.ticket.edit', ['ticket' => $ticket?->id]) }}">Edit</a>
                                            </li>
                                            <li class="px-5 py-1 text-center bg-white">
                                                <a
                                                    href="{{ route('admin.ticket.show', ['ticket' => $ticket?->id]) }}">View</a>
                                            </li>
                                            <li class="px-5 py-1 text-center bg-red-600 text-white">
                                                <a href="#">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @empty
            <div>
                <p class="text-center">
                    <span class="text-red-500 font-inter font-bold text-lg">No data found !!</span>
                </p>
            </div>
        @endforelse

    </div>

    @section('script')
        <script>
            function toggleSubmenu(row) {
                const mainRow = row;
                const submenu = mainRow.nextElementSibling;
                const toggleIcon = mainRow.querySelector('.arrow');

                if (submenu.style.display === 'table-row') {
                    submenu.style.display = 'none';
                    toggleIcon.innerHTML = `<svg width="5" height="15" viewBox="0 0 5 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0L5 5L0 10V0Z" fill="#666666" />
                                            </svg>`;
                } else {
                    submenu.style.display = 'table-row';
                    toggleIcon.innerHTML = `<svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0L5 5L10 0H0Z" fill="#666666"/>
                                            </svg>`;
                }
            }
        </script>
        <script>
            // function toggleAction(ticketId) {
            //     var actionDiv = document.getElementById('action-' + ticketId);
            //     var openMenus = document.querySelectorAll('[id="action-"]');
            //     console.log(openMenus)
            //     openMenus.forEach(function(menu) {
            //         if (menu.id !== 'action-' + ticketId) {
            //             menu.style.display = 'none';

            //         }
            //     });



            //     // Toggle the current actionDiv
            //     if (actionDiv.style.display === 'none' || actionDiv.style.display === '') {
            //         actionDiv.style.display = 'block';

            //         // Add a one-time event listener to the window to close the menu when clicking outside
            //         window.addEventListener('click', function(event) {
            //             if (!actionDiv.contains(event.target) && event.target.closest('.toggleButton') === null) {
            //                 actionDiv.style.display = 'none';
            //             }
            //         }, {
            //             once: true
            //         });

            //     } else {
            //         actionDiv.style.display = 'none';
            //     }
            // }

            function toggleAction(ticketId) {
                var actionDiv = document.getElementById('action-' + ticketId);
                if (actionDiv.style.display === 'none' || actionDiv.style.display === '') {
                    actionDiv.style.display = 'block';
                } else {
                    actionDiv.style.display = 'none';
                }
            }
        </script>
    @endsection

    @section('style')
        <style>
            .submenu {
                display: table-row;
            }

            .main-row.active+.submenu {
                display: none;
            }

            .main-row.active .toggle-icon {
                background-color: red;
            }
        </style>
    @endsection
</x-app-layout>
