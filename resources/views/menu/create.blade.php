<x-app-layout>
    @section('title', 'Create Menu')
    @section('breadcrumb')
    <x-breadcrumb>
        Create Menu
    </x-breadcrumb>
    @endsection
    <livewire:menu.create-menu :roles="$roles" :parent_menus="$parent_menus" :routes="$routes" :permission_list="$permission_list" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initSelect2('role');
            initSelect2('permission');
        });
    </script>
</x-app-layout>