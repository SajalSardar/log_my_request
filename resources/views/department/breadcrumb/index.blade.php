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
                'title' => 'Department',
                'route' => route('admin.department.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>