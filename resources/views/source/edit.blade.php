<x-app-layout>
    @section('title', 'Edit Source')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Source
        </x-breadcrumb>
    @endsection
    <livewire:source.update-source :source="$source" />
</x-app-layout>
