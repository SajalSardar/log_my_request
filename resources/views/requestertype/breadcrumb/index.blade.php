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
                'title' => 'Requester Type',
                'route' => route('admin.requestertype.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>