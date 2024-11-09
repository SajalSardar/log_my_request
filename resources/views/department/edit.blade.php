<x-app-layout>
    @section('title', 'Update Department')
    @section('breadcrumb')
    <x-breadcrumb>
        Update Department
    </x-breadcrumb>
    @endsection
    <livewire:department.update-department :department="$department" />
</x-app-layout>