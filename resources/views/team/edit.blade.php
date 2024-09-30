<x-app-layout>
    <livewire:team.update-team :team="$team" :agentUser="$agentUser" :categories="$categories" />
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                reinitializeSelect2();
            });

            document.addEventListener('livewire:init', () => {
                $('#categories_input').on('select2:select', function(e) {
                    let value = $(this).val();
                    @this.set('categories_input', value);
                });
            });

            // Livewire.on('componentUpdated', () => {
            //     $('.select2').select2();


            //     Livewire.hook('message.processed', (message, component) => {
            //         let selectedValues = $('.select2').val(); // Preserve selected values
            //         $('.select2').select2(); // Reinitialize Select2 after each update
            //         $('.select2').val(selectedValues).trigger('change'); // Restore selected values
            //     });
            // });
        </script>
    @endsection
</x-app-layout>
