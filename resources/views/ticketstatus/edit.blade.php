<x-app-layout>
    @section('title', 'Edit Request Status')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Request Status
        </x-breadcrumb>
    @endsection
    <livewire:ticketstatus.update-ticketstatus :ticketstatus="$ticketstatus" />
</x-app-layout>
