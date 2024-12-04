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
                'title' => 'Team',
                'route' => route('admin.team.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create',
                'route' => route('admin.team.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>