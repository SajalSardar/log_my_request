<div>
    @php
        $response = [
            [
                'title' => 'Home',
                'route' => route('dashboard'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>