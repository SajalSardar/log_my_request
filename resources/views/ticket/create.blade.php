<x-app-layout>
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                reinitializeSelect2();
            });
        </script>
    @endsection
<livewire:ticket.create-ticket />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initSelect2form('owner_id');
        });
    </script>
</x-app-layout>
