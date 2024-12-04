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
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Update',
                'route' => '#'
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>