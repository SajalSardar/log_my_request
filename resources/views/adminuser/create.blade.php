<x-app-layout>
    @section('title', 'Create User')
    @section('breadcrumb')
    <x-breadcrumb>
        Create User
    </x-breadcrumb>
    @endsection
    @livewire('admin-user.create-admin-user')
</x-app-layout>