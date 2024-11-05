<x-app-layout>
    @section('title', 'Edit Request Type')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Request Type
        </x-breadcrumb>
    @endsection

    <livewire:requester-type.update-requester-type :requestertype="$requestertype" />
</x-app-layout>
