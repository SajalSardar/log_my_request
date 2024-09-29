<x-app-layout>
    <div class="relative overflow-x-auto">
        <table class="w-full overflow-x-auto">

            <tbody class="mt-5">
                @forelse ($tickets as $each)
                    @if ($each->name)
                        <tr class="main-row" style="cursor: pointer;border-bottom:1px solid #dadada" onclick="toggleSubmenu(this)">
                            <td colspan="14" class="text-black font-inter font-semibold py-3">
                                <div class="flex justify-between">
                                    <div class="status_count flex items-center">
                                        <span>{{ $each?->name . ' Request' }} {{ '(' . $each?->ticket_count . ')' }}</span>
                                        <span class="pl-2 arrow">
                                            <svg width="5" height="15" viewBox="0 0 5 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0L5 5L0 10V0Z" fill="#666666" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <a target="__blank" href="{{ route('admin.ticket.viewAll', ['ticket_status_id' => $each?->id]) }}" class="border border-slate-300 rounded font-inter font-normal px-2 py-1">View All</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif

                    <tr class="rounded shadow submenu" style="display: none;">
                        <td colspan="15">
                            <table class="w-full overflow-x-auto">
                                <thead class="w-full bg-slate-100 mb-5">
                                    <tr>
                                        <th class="text-start p-2" style="width: 70px">Select</th>
                                        <th class="text-start p-2" style="width: 70px">ID</th>
                                        <th class="text-start p-2" style="width: 80px">Priority</th>
                                        <th class="text-start p-2" style="width: 210px">Requester Name</th>
                                        <th class="text-start p-2">Requester Type</th>
                                        <th class="text-start p-2">Assigned Team</th>
                                        <th class="text-start p-2">Assigned Agent</th>
                                        <th class="text-start p-2">Created Date</th>
                                        <th class="text-start p-2" style="width: 210px">Request Age</th>
                                        <th class="text-start p-2">Source</th>
                                        <th class="text-start p-2">Due Date</th>
                                        <th class="text-start p-2"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($each->ticket as $ticket)
                                        <tr>
                                            <td class="p-2" style="width: 70px">
                                                <x-forms.checkbox-input />
                                            </td>
                                            <td class="p-2" style="width: 70px">
                                                <span class="font-inter font-bold">
                                                    #{{ $ticket?->id }}
                                                </span>
                                            </td>
                                            <td class="p-2 font-normal text-gray-400" style="width: 80px">
                                                <span class="text-{{ $each?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-bold">
                                                    {{ $each?->priority }}
                                                </span>
                                            </td>

                                            <td class="p-2 font-normal text-gray-400 flex justify-between items-center" style="width: 210px">
                                                <img src="https://i.pravatar.cc/300/5" alt="img" width="50" height="50" style="border-radius: 50%">
                                                <span class="ml-2">
                                                    {{ $ticket?->requester_name }}
                                                </span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">
                                                    {{ $ticket?->requester_type?->name }}
                                                </span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">
                                                    {{ $ticket?->team?->name }}
                                                </span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">Cody Fisher</span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">{{ Helper::humanReadableDate($ticket?->created_at) }}</span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">{{ Helper::ISODate($ticket?->due_date) }}</span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">{{ $ticket?->source?->title }}</span>
                                            </td>
                                            <td class="p-2">
                                                <span class="font-normal text-gray-400">17 Oct, 2024</span>
                                            </td>
                                            <td class="relative">
                                                <button onclick="toggleAction({{ $ticket->id }})">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                                <div id="action-{{ $ticket->id }}" class="absolute top-5 right-10" style="display: none">
                                                    <ul>
                                                        <li class="px-3 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                                            <a href="{{ route('admin.ticket.edit', ['ticket' => $ticket?->id]) }}">Edit</a>
                                                        </li>
                                                        <li class="px-3 py-1 text-center">
                                                            <a href="#">View</a>
                                                        </li>
                                                        <li class="px-3 py-1 text-center bg-red-600 text-white">
                                                            <a href="#">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="14" class="text-center">
                            <span class="text-red">No data found !!</span>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    @section('script')
        <script>
            function toggleSubmenu(row) {
                const mainRow = row;
                const submenu = mainRow.nextElementSibling;
                mainRow.classList.toggle('active');
                const toggleIcon = mainRow.querySelector('.arrow');

                if (submenu.style.display === 'none' || submenu.style.display === '') {
                    submenu.style.display = 'table-row';
                    toggleIcon.innerHTML = `<svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0L5 5L10 0H0Z" fill="#666666"/>
                                            </svg>`;
                } else {
                    submenu.style.display = 'none';
                    toggleIcon.innerHTML = `<svg width="5" height="15" viewBox="0 0 5 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0L5 5L0 10V0Z" fill="#666666" />
                                            </svg>`;
                }
            }
        </script>
        <script>
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
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .main-row.active+.submenu {
                display: table-row;
                opacity: 1;
            }

            .main-row.active .toggle-icon {
                background-color: red;
            }

            .icon_style {
                width: 20px;
                height: 20px;
                display: inline-block;
                border-radius: 50%;
                line-height: 20px;
                vertical-align: middle;
                text-align: center;
                background: #00830b;
            }

            .list-group-item ul.list-group li {
                border: none;
            }
        </style>
    @endsection
</x-app-layout>
