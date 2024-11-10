<x-app-layout>
    @section('title', 'Edit Request Type')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Request Type
        </x-breadcrumb>
    @endsection

    <livewire:requestertype.update-requestertype :requestertype="$requestertype" />
</x-app-layout>
