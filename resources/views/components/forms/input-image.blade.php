<div class="custom_file" style="position: relative;">
    <input id="attachment" style="position: absolute;opacity:0" type="file" {!! $attributes->merge(['class' => '']) !!}>
    <button type="button" class="px-5 py-1 border border-base-500 rounded bg-[#f3f4f6] flex items-center">
        <span id="attachmentName" class="text-paragraph" wire:ignore>Image</span>
        <span class="pl-2">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 9C8.32843 9 9 8.32843 9 7.5C9 6.67157 8.32843 6 7.5 6C6.67157 6 6 6.67157 6 7.5C6 8.32843 6.67157 9 7.5 9Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#5C5C5C" stroke-width="1.5" />
                <path d="M5 20.9999C9.37246 15.775 14.2741 8.88398 21.4975 13.5424" stroke="#5C5C5C" stroke-width="1.5" />
            </svg>
        </span>
    </button>
</div>