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
                'title' => 'Users',
                'route' => route('admin.user.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>