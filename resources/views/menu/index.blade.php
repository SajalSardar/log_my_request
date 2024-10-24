<x-app-layout>

    <div class="flex mb-8">
        <div class="flex-none  w-48">
            <p class="font-bold">{{ Str::ucfirst(request()->get('ticket_status')) }} request</p>
        </div>
        <div class="flex-1">
            <div class="flex justify-end gap-2">
                <div>
                    <x-forms.text-input id="unser_name_search" class="text-sm" placeholder="Search.." />
                </div>

                <div>
                    <x-actions.href href="{{ route('admin.menu.create') }}" class="!px-2 !py-0.5 inline-block">
                        Create Ticket
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
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Order</th>
                    <th>Route</th>
                    <th>Role</th>
                    <th>Url</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                {{-- @forelse ($collections as $each)
                    <tr class="rounded shadow">
                        <td class="p-3 flex">
                            <div class="profile">
                                {!! $each->icon !!}
                            </div>
                            <div class="infos ps-5">
                                <h5 class="font-medium text-slate-900">{{ $each?->name }}</h5>
                            </div>
                        </td>
                        <td class="p-3 font-normal text-gray-400">{{ $each->order }}</td>
                        <td class="p-3 font-normal text-gray-400">{{ $each?->route }}</td>
                        <td class="p-3 font-normal text-gray-400">
                            @foreach (json_decode($each?->roles) as $key => $role)
                                {!! Helper::badge($role) !!}
                            @endforeach
                        </td>
                        <td class="p-3 font-normal text-gray-400">{{ $each?->url }}</td>
                        <td>
                            <div class="flex">
                                <x-actions.edit route="{{ route('admin.menu.edit', ['menu' => $each?->id]) }}" />
                                <x-actions.delete action="{{ route('admin.menu.destroy', ['menu' => $each->id]) }}" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <h5 class="font-medium text-slate-900">No data found !!!</h5>
                        </td>
                    </tr>
                @endforelse --}}

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
                        url: "{{ route('admin.menu.list.datatable') }}",
                        type: "GET",
                        data: function(d) {
                            d._token = "{{ csrf_token() }}";
                            d.unser_name_search = $('#unser_name_search').val();
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
                            data: 'order',
                            name: 'order'
                        },
                        {
                            data: 'route',
                            name: 'route'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'url',
                            name: 'url'
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
