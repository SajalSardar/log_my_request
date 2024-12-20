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
                'route' => route('admin.menu.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Menu',
                'route' => route('admin.menu.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Update Menu',
                'route' => '#',
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>