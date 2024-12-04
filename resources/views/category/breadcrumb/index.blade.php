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
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>