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
                'title' => 'Category',
                'route' => route('admin.category.index'),
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