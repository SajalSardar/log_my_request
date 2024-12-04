<div>
    @php
        $response = [
            [
                'title' => 'Home',
                'route' => route('dashboard'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Ticket Status',
                'route' => route('admin.ticketstatus.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create',
                'route' => route('admin.ticketstatus.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>