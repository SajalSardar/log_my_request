<x-app-layout>
    @section('title', 'Update User')
    @section('breadcrumb')
    <x-breadcrumb>
        Update User
    </x-breadcrumb>
    @endsection
    @livewire('admin-user.update-admin-user', ['user' => $user])
</x-app-layout>