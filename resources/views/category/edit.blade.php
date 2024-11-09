<x-app-layout>
    @section('title', 'Edit Category')
    @section('breadcrumb')
    <x-breadcrumb>
        Update Category
    </x-breadcrumb>
    @endsection
    <livewire:category.update-category :category="$category" :parent_categories="$parent_categories" />
</x-app-layout>