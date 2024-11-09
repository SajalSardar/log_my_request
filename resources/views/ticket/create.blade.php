<x-app-layout>
    @section('title', 'Create Request')
    @section('breadcrumb')
    <x-breadcrumb>
        Create Request
    </x-breadcrumb>
    @endsection

    <livewire:ticket.create-ticket />
</x-app-layout>