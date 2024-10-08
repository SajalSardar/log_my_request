<x-app-layout>
    <div class="relative overflow-x-auto">
        <table class="w-full overflow-x-auto !py-10" id="data-table">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    {{-- <th class="text-start p-2" style="width: 80px">
                        <div class="flex items-center">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 5H4.16667H17.5" stroke="#666666" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M15.8332 5.00008V16.6667C15.8332 17.1088 15.6576 17.5327 15.345 17.8453C15.0325 18.1578 14.6085 18.3334 14.1665 18.3334H5.83317C5.39114 18.3334 4.96722 18.1578 4.65466 17.8453C4.3421 17.5327 4.1665 17.1088 4.1665 16.6667V5.00008M6.6665 5.00008V3.33341C6.6665 2.89139 6.8421 2.46746 7.15466 2.1549C7.46722 1.84234 7.89114 1.66675 8.33317 1.66675H11.6665C12.1085 1.66675 12.5325 1.84234 12.845 2.1549C13.1576 2.46746 13.3332 2.89139 13.3332 3.33341V5.00008"
                                        stroke="#666666" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M8.3335 9.16675V14.1667" stroke="#666666" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.6665 9.16675V14.1667" stroke="#666666" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="ms-1">Select</span>
                        </div>
                    </th> --}}
                    <th class="text-start p-2" style="width: 70px">ID</th>
                    {{-- <th class="text-start p-2" style="width: 200px">Title</th>
                    <th class="text-start p-2" style="width: 80px">Priority</th>
                    <th class="text-start p-2" style="max-width: 130px">Status</th>
                    <th class="text-start p-2" style="width: 210px">Requester Name</th>
                    <th class="text-start p-2" style="max-width: 150px">Requester Type</th>
                    <th class="text-start p-2" style="max-width: 130px">Assigned Team</th>
                    <th class="text-start p-2" style="max-width: 140px">Assigned Agent</th>
                    <th class="text-start p-2" style="max-width: 120px">Created Date</th>
                    <th class="text-start p-2" style="width: 120px">Request Age</th>
                    <th class="text-start p-2">Source</th>
                    <th class="text-start p-2">Due Date</th> --}}
                    <th class="text-start p-2"></th>
                </tr>
            </thead>

            <tbody class="mt-5">
                {{-- @forelse ($tickets as $each)
                    <tr class="rounded shadow">

                        <td class="p-2" style="width: 70px">
                            <x-forms.checkbox-input />
                        </td>
                        <td class="p-2" style="width: 70px">
                            <span class="font-inter font-bold">
                                #{{ $each?->id }}
                            </span>
                        </td>
                        <td class="p-2" style="width:200px">
                            <span class="font-normal text-gray-400 text-base">
                                {{ Str::limit(value: $each?->title, limit: 40, end: '...') }}
                            </span>
                        </td>

                        <td class="p-2 font-normal text-gray-400" style="width: 80px">
                            <span
                                class="text-{{ $each?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-bold">
                                {{ $each?->priority }}
                            </span>
                        </td>

                        <td class="p-2 font-normal text-gray-400">
                            <x-buttons.primary class="font-inter font-bold !bg-open-400">
                                {{ $each?->ticket_status?->name }}
                            </x-buttons.primary>
                        </td>

                        <td class="p-2 font-normal text-gray-400 flex items-center" style="width: 210px">
                            <img src="https://i.pravatar.cc/300/5" alt="img" width="50" height="50"
                                style="border-radius: 50%">
                            <span class="ml-2">
                                {{ $each?->user?->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 150px">
                            <span class="font-normal text-gray-400">
                                {{ $each?->requester_type?->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 130px">
                            <span class="font-normal text-gray-400">
                                {{ $each?->team?->name }}
                            </span>
                        </td>
                        <td class="p-2" style="max-width: 140px">
                            <span class="font-normal text-gray-400">{{ @$each->owners->pluck('name') }}</span>
                        </td>
                        <td class="p-2" style="max-width: 120px">
                            <span class="font-normal text-gray-400">{{ Helper::ISODate($each?->created_at) }}</span>
                        </td>
                        <td class="p-2" style="max-width:120px">
                            <span
                                class="font-normal text-gray-400">{{ Helper::dayMonthYearHourMininteSecond($each?->created_at, true, true, true) }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ $each?->source?->title }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ Helper::ISOdate($each->due_date) }}</span>
                        </td>
                        <td class="relative">
                            <button onclick="toggleAction({{ $each->id }})"
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
                            <div id="action-{{ $each->id }}" class="shadow-lg z-40 absolute top-5 right-16"
                                style="display: none">
                                <ul>
                                    <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                        <a href="{{ route('admin.ticket.edit', ['ticket' => $each?->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-white">
                                        <a href="{{ route('admin.ticket.show', ['ticket' => $each?->id]) }}">View</a>
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
                        <td colspan="14" class="text-center">
                            <span class="text-red">No data found !!</span>
                        </td>
                    </tr>
                @endforelse --}}

            </tbody>
        </table>
    </div>

    @section(section: 'script')
        <script>
            function toggleAction(ticketId) {
                var actionDiv = document.getElementById('action-' + ticketId);
                if (actionDiv.style.display === 'none' || actionDiv.style.display === '') {
                    actionDiv.style.display = 'block';
                } else {
                    actionDiv.style.display = 'none';
                }
            }

            $(function() {
                var dTable = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin.ticket.status.wise.list.datatable') }}",
                        type: "GET",
                        data: function(d) {
                            d._token = "{{ csrf_token() }}";
                            d.query_status = "{{ $queryStatus }}";
                            // d.title = $('select[name=title]').val();
                            // d.fromdate = $('input[name=fromdate]').val();
                            // d.todate = $('input[name=todate]').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'action_column',
                            name: 'action_column'
                        }
                    ]
                });
                $('#filterForm').on('submit', function(e) {
                    dTable.draw();
                    e.preventDefault();
                });
            });
        </script>
    @endsection
</x-app-layout>
