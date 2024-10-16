<x-app-layout>
    <div class="mb-10">
        <form action="">
            <div class="grid md:grid-cols-6 sm:grid-cols-1 sm:gap-1 md:gap-4">
                <div>
                    <x-forms.text-input id="ticket_id_search" class="text-sm" placeholder="Ticket Id" />
                </div>
                <input type="hidden" id="me_mode_search"
                    value="{{ request()->has('me_mode') ? request()->get('me_mode') : '' }}">
                <div class="relative" x-data="{ priority: '' }">
                    <x-forms.select-input x-model="priority" class="text-sm" name='priority_search'
                        id="priority_search">
                        <option value="">Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </x-forms.select-input>
                    <span x-show="priority"
                        class="absolute top-2 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base"
                        tabindex="0" style="display: block;"
                        @click="priority = '';$nextTick(() => $('#priority_search').trigger('change'))">✕</span>
                </div>

                <div class="relative" x-data="{ status: '' }">
                    <x-forms.select-input x-model="status" class="text-sm" id="status_search">
                        <option value="">Status</option>
                        @foreach ($ticketStatus as $ticketStatus)
                            <option value="{{ $ticketStatus->id }}">{{ $ticketStatus->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                    <span x-show="status"
                        class="absolute top-2 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base"
                        tabindex="0" style="display: block;"
                        @click="status = '';$nextTick(() => $('#status_search').trigger('change'))">✕</span>
                </div>

                <div class="relative" x-data="{ category: '' }">
                    <x-forms.select-input x-model="category" class="text-sm" id="category_search">
                        <option value="">Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                    <span x-show="category"
                        class="absolute top-2 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base"
                        tabindex="0" style="display: block;"
                        @click="category = '';$nextTick(() => $('#category_search').trigger('change'))">✕</span>
                </div>
                <div class="relative" x-data="{ team: '' }">
                    <x-forms.select-input class="text-sm" x-model="team" id="team_search">
                        <option value="">Team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                    <span x-show="team"
                        class="absolute top-2 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base"
                        tabindex="0" style="display: block;"
                        @click="team = '';$nextTick(() => $('#team_search').trigger('change'))">✕</span>
                </div>
                <div class="relative" x-data="{ due_date_x: '' }">
                    <x-forms.select-input class="text-sm" x-model="due_date_x" id="due_date_search">
                        <option value="">Due Date</option>
                        <option value="today">Today</option>
                        <option value="tomorrow">Tomorrow</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                    </x-forms.select-input>
                    <span x-show="due_date_x"
                        class="absolute top-2 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base"
                        tabindex="0" style="display: block;"
                        @click="due_date_x = '';$nextTick(() => $('#due_date_search').trigger('change'))">✕</span>
                </div>

            </div>
        </form>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full !py-10" id="data-table">
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
                    <th class="text-start p-2" style="width: 300px">Title</th>
                    <th class="text-start p-2">Priority</th>
                    <th class="text-start p-2">Category</th>
                    <th class="text-start p-2" style="width: 200px">Status</th>
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
                    searching: false,
                    ajax: {
                        url: "{{ route('admin.all.ticket.list.datatable') }}",
                        type: "GET",
                        data: function(d) {
                            d._token = "{{ csrf_token() }}";
                            d.me_mode_search = $('#me_mode_search').val();
                            d.ticket_id_search = $('#ticket_id_search').val();
                            d.priority_search = $('#priority_search').val();
                            d.category_search = $('#category_search').val();
                            d.team_search = $('#team_search').val();
                            d.status_search = $('#status_search').val();
                            d.due_date_search = $('#due_date_search').val();
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
                            data: 'ticket_status_id',
                            name: 'ticket_status_id'
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

                $(document).on('change keyup',
                    '#priority_search, #category_search, #team_search, #status_search, #due_date_search, #ticket_id_search',
                    function(e) {
                        dTable.draw();
                        e.preventDefault();
                    });
            });
        </script>
    @endsection
</x-app-layout>
