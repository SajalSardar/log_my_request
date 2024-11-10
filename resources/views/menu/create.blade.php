<x-app-layout>
    @section('title', 'Create Menu')
    @section('breadcrumb')
    <x-breadcrumb>
        Create Menu
    </x-breadcrumb>
    @endsection
    <livewire:menu.create-menu :roles="$roles" :parent_menus="$parent_menus" :routes="$routes" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initSelect2('role');
        });
    </script>
</x-app-layout>