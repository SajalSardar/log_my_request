<div class="custom_file" style="position: relative;">
    <input id="attachment" style="position: absolute;opacity:0" type="file" {!! $attributes->merge(['class' => '']) !!}>
    <button type="button" class="px-5 py-1 border border-slate-300 rounded bg-gray-200 flex items-center">
        <span id="attachmentName" wire:ignore> Attach File</span>
        <span class="pl-2">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 17H16" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 13H12" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13 2.5V3C13 5.82843 13 7.24264 13.8787 8.12132C14.7574 9 16.1716 9 19 9H19.5M20 10.6569V14C20 17.7712 20 19.6569 18.8284 20.8284C17.6569 22 15.7712 22 12 22C8.22876 22 6.34315 22 5.17157 20.8284C4 19.6569 4 17.7712 4 14V9.45584C4 6.21082 4 4.58831 4.88607 3.48933C5.06508 3.26731 5.26731 3.06508 5.48933 2.88607C6.58831 2 8.21082 2 11.4558 2C12.1614 2 12.5141 2 12.8372 2.11401C12.9044 2.13772 12.9702 2.165 13.0345 2.19575C13.3436 2.34355 13.593 2.593 14.0919 3.09188L18.8284 7.82843C19.4065 8.40649 19.6955 8.69552 19.8478 9.06306C20 9.4306 20 9.83935 20 10.6569Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </button>
</div>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let attachment = document.querySelector('#attachment');
            let attachmentName = document.querySelector('#attachmentName');

            attachment.addEventListener('change', function(event) {
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
