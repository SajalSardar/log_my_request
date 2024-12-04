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
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create',
                'route' => route('admin.department.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>