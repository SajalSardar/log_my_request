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
                'title' => 'role',
                'route' => route('admin.role.index'),
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