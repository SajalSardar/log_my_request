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
                    <th class="text-start p-2">ID</th>
                    <th class="text-start p-2">Title</th>
                    <th class="text-start p-2">Priority</th>
                    <th class="text-start p-2">Category</th>
                    <th class="text-start p-2">Status</th>
                    <th class="text-start p-2">Requester Name</th>
                    <th class="text-start p-2">Assigned Team</th>
                    <th class="text-start p-2">Assigned Agent</th>
                    <th class="text-start p-2">Created Date</th>
                    <th class="text-start p-2">Request Age</th>
                    <th class="text-start p-2">Due Date</th>
                    <th class="text-start p-2"></th>
                </tr>
            </thead>

            <tbody class="mt-5">
            </tbody>
        </table>
    </div>

    @section('script')
        <script>
            $(function() {
                var dTable = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin.all.ticket.list.datatable') }}",
                        type: "GET",
                        data: function(d) {
                            d._token = "{{ csrf_token() }}";
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
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'priority',
                            name: 'priority'
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'user_id',
                            name: 'user_id'
                        },
                        {
                            data: 'team_id',
                            name: 'team_id'
                        },
                        {
                            data: 'agent',
                            name: 'agent'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'request_age',
                            name: 'request_age'
                        },
                        {
                            data: 'due_date',
                            name: 'due_date'
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
