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
                'title' => 'Roles',
                'route' => route('admin.role.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>