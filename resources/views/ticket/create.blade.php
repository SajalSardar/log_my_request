<x-app-layout>
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                reinitializeSelect2();
            });
        </script>
    @endsection
    <livewire:ticket.create-ticket />


</x-app-layout>
