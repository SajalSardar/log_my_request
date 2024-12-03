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
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>