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
                'title' => 'Request',
                'route' => route('admin.ticket.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>