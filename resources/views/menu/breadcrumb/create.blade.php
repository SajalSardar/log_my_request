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
            ],            [
                'title' => 'Create',
                'route' => route('admin.menu.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>