<x-app-layout>
    <livewire:ticket.create-ticket />
    @section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let attachment = document.querySelector('#attachment');
            let attachmentName = document.querySelector('#attachmentName');

            attachment.addEventListener('change', function (event) {
                event.preventDefault();
                let files = event.target.files;
                if (files.length > 0) {
                    let filename = files[0].name;
                    attachmentName.innerHTML = filename;
                }
            });
        });
    </script>
    @endsection
</x-app-layout>