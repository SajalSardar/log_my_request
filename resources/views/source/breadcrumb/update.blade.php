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
                'title' => 'Settings',
                'route' => route('admin.source.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Source',
                'route' => route('admin.source.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Update Source',
                'route' => '#',
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>