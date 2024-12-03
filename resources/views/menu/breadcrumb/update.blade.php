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
                'title' => 'Menu',
                'route' => route('admin.menu.index'),
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