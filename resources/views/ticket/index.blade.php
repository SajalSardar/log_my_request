<x-app-layout>
    <div class="relative overflow-x-auto">
        <table class="w-full overflow-x-auto">

            <tbody class="mt-5">
                @forelse ($tickets as $each)
                    @if ($each->name)
                        <tr class="main-row" onclick="toggleSubmenu(this)">
                            <td colspan="14" class="text-black font-inter font-semibold">{{ $each?->name . ' Request' }} {{ '(' . $each?->ticket_count . ')' }}</td>
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
                                                <span class="text-{{ $ticket?->priority === 'medium' ? 'teal' : 'info' }}-400 font-inter font-bold">
                                                    {{ $ticket?->priority }}
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
                                            <td>
                                                <button>
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
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
                const toggleIcon = mainRow.querySelector('.toggle-icon i');

                if (submenu.style.display === 'none' || submenu.style.display === '') {
                    submenu.style.display = 'table-row';
                    toggleIcon.classList.remove('fa-plus');
                    toggleIcon.classList.add('fa-minus');
                    mainRow.style.backgroundColor = 'red';
                } else {
                    submenu.style.display = 'none';
                    toggleIcon.classList.remove('fa-minus');
                    toggleIcon.classList.add('fa-plus');
                    mainRow.style.backgroundColor = '#0883d4';
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
