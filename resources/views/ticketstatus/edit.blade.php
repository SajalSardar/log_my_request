<x-app-layout>
    @section('title', 'Edit Request Status')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Request Status
        </x-breadcrumb>
    @endsection
    <livewire:ticket-status.update-ticket-status :ticketstatus="$ticketstatus" />
</x-app-layout>
