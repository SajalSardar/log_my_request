<x-app-layout>
    @section('title', 'Create Category')
    @section('breadcrumb')
    <x-breadcrumb>
        Create Category
    </x-breadcrumb>
    @endsection
    <livewire:category.create-category :parent_categories="$parent_categories" />
</x-app-layout>