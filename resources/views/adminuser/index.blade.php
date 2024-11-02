<x-app-layout>
    @section('title', 'User List')
    @section('breadcrumb')
        <x-breadcrumb>
            User List
        </x-breadcrumb>
    @endsection
    <div class="flex mb-8">
        <div class="flex-none  w-48">
            <p class="font-bold">User List</p>
        </div>
        <div class="flex-1">
            <div class="flex justify-end gap-2">
                <div>
                    <x-forms.text-input id="unser_name_search" class="text-sm" placeholder="Name" />
                </div>
                <div>
                    <x-forms.text-input id="unser_email_search" class="text-sm" placeholder="Email" />
                </div>

                <div>
                    <x-actions.href href="{{ route('admin.user.create') }}" class="block">
                        Create User
                        <svg class="inline-block" fill="none" width="15" height="15" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                    </x-actions.href>
                </div>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto bg-white">

        <table class="w-full display nowrap" id="data-table">
            <thead>
                <tr class="!text-left">
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>


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
                    scrollX: true,
                    order: [
                        0, 'desc'
                    ],
                    ajax: {
                        url: "{{ route('admin.user.list.datatable') }}",
                        type: "GET",
                        data: function(d) {
                            d._token = "{{ csrf_token() }}";
                            d.unser_name_search = $('#unser_name_search').val();
                            d.unser_email_search = $('#unser_email_search').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action_column',
                            name: 'action_column'
                        }
                    ]
                });
                $(document).on('change keyup',
                    '#unser_name_search, #unser_email_search',
                    function(e) {
                        dTable.draw();
                        e.preventDefault();
                    });
            });
        </script>
    @endsection
</x-app-layout>
