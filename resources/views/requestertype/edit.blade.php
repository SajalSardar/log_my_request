<x-app-layout>
    @section('title', 'Edit Request Type')
    @include('requestertype.breadcrumb.update')
    <livewire:requestertype.update-requestertype :requestertype="$requestertype" />
</x-app-layout>
