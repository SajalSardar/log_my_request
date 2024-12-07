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
                'title' => 'Admin',
                'route' => route('admin.role.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Role',
                'route' => route('admin.role.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>