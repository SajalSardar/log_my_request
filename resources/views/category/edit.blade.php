<x-app-layout>
    @section('title', 'Update Category')
    @section('breadcrumb')
    <x-breadcrumb>
        Update Category
    </x-breadcrumb>
    @endsection
    <livewire:category.update-category :category="$category" :parent_categories="$parent_categories" />
</x-app-layout>