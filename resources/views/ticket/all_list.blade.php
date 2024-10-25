<x-app-layout>
    <div class="grid lg:grid-cols-8 lg:gap-2 md:grid-cols-4 md:gap-2 sm:grid-cols-2 sm:gap-2 mb-5">
        <div class="">
            <p class="text-heading-dark">All request</p>
            <span class="text-caption">(Showing 19 of 120 requests)</span>
        </div>
        <div>
            <input type="hidden" id="me_mode_search" value="{{ Route::is('admin.ticket.list.active.memode') ? 'me_mode' : '' }}">
            <x-forms.text-input-icon dir="start" id="ticket_id_search" class="text-sm" placeholder="Search ID or Name">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.0004 20.9999L16.6504 16.6499" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-forms.text-input-icon>
        </div>
        <div class="relative" x-data="{ priority: '' }">
            <x-forms.select-input x-model="Priority" name='priority_search' id="priority_search">
                <option value="">Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </x-forms.select-input>
            <span x-show="priority" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="priority = '';$nextTick(() => $('#priority_search').trigger('change'))">✕</span>
        </div>
        <div class="relative" x-data="{ status: '' }">
            <x-forms.select-input x-model="status" class="text-sm" id="status_search">
                <option value="">Status</option>
                @foreach ($ticketStatus as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </x-forms.select-input>
            <span x-show="status" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="status = '';$nextTick(() => $('#status_search').trigger('change'))">✕</span>
        </div>
        <div class="relative" x-data="{ category: '' }">
            <x-forms.select-input x-model="category" class="text-sm" id="category_search">
                <option value="">Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-forms.select-input>
            <span x-show="category" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="category = '';$nextTick(() => $('#category_search').trigger('change'))">✕</span>
        </div>
        <div class="relative" x-data="{ team: '' }">
            <x-forms.select-input class="text-sm" x-model="team" id="team_search">
                <option value="">Team</option>
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </x-forms.select-input>
            <span x-show="team" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="team = '';$nextTick(() => $('#team_search').trigger('change'))">✕</span>
        </div>
        <div class="relative" x-data="{ due_date_x: '' }">
            <x-forms.select-input class="text-sm" x-model="due_date_x" id="due_date_search">
                <option value="">Due Date</option>
                <option value="today">Today</option>
                <option value="tomorrow">Tomorrow</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
            </x-forms.select-input>
            <span x-show="due_date_x" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="due_date_x = '';$nextTick(() => $('#due_date_search').trigger('change'))">✕</span>
        </div>
        <div>
            <x-actions.href href="{{ route('admin.ticket.create') }}" class="flex items-center gap-1 text-heading-light">
                <span>Create Ticket</span>
                <svg fill="none" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-actions.href>
        </div>
    </div>

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%">
            <thead>
                <tr>
                    <th class="text-start p-2 text-heading-dark" style="width: 80px">
                        <div class="flex items-center">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 5H4.16667H17.5" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15.8332 5.00008V16.6667C15.8332 17.1088 15.6576 17.5327 15.345 17.8453C15.0325 18.1578 14.6085 18.3334 14.1665 18.3334H5.83317C5.39114 18.3334 4.96722 18.1578 4.65466 17.8453C4.3421 17.5327 4.1665 17.1088 4.1665 16.6667V5.00008M6.6665 5.00008V3.33341C6.6665 2.89139 6.8421 2.46746 7.15466 2.1549C7.46722 1.84234 7.89114 1.66675 8.33317 1.66675H11.6665C12.1085 1.66675 12.5325 1.84234 12.845 2.1549C13.1576 2.46746 13.3332 2.89139 13.3332 3.33341V5.00008" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8.3335 9.16675V14.1667" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.6665 9.16675V14.1667" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="ms-1">Select</span>
                        </div>
                    </th>
                    <th class="text-heading-dark">ID</th>
                    <th class="text-heading-dark">Title</th>
                    <th class="text-heading-dark">Priority</th>
                    <th class="text-heading-dark">Category</th>
                    <th class="text-heading-dark">Status</th>
                    <th class="text-heading-dark">Requester Name</th>
                    <th class="text-heading-dark">Assigned Team</th>
                    <th class="text-heading-dark">Assigned Agent</th>
                    <th class="text-heading-dark">Created Date</th>
                    <th class="text-heading-dark">Request Age</th>
                    <th class="text-heading-dark">Due Date</th>
                    <th class="text-heading-dark"></th>
                </tr>
            </thead>

            <tbody class="mt-5">
            </tbody>
        </table>
    </div>

    @section('script')
    <script>
        $(function () {
            var dTable = $('#data-table').DataTable({
                stripeClasses: [],
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                scrollX: true,
                autoWidth: false,
                order: [[0, 'desc']], // Corrected syntax for 'order'
                ajax: {
                    url: "{{ route('admin.all.ticket.list.datatable') }}",
                    type: "GET",
                    data: function (d) {
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
                columns: [
                    { data: 'select', name: 'select', visible: true },
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'priority', name: 'priority' },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'ticket_status_id', name: 'ticket_status_id' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'team_id', name: 'team_id' },
                    { data: 'agent', name: 'agent' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'request_age', name: 'request_age' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'action_column', name: 'action_column' }
                ],
                columnDefs: [
                    { width: "50px", targets: 0 },
                    { width: "50px", targets: 1 },
                    { width: "325px", targets: 2 },
                    { width: "80px", targets: 3 }
                ]
            });

            $(document).on('change keyup',
                '#priority_search, #category_search, #team_search, #status_search, #due_date_search, #ticket_id_search',
                function (e) {
                    dTable.draw();
                    e.preventDefault();
                });
        });
    </script>
    @endsection
</x-app-layout>