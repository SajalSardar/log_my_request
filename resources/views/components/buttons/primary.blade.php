<button {{ $attributes->merge(['type' => 'submit', 'class' => 'hover:bg-primary-400 flex justify-center items-center gap-2 hover:text-gray-100 border border-slate-200 px-8 py-2 bg-gray-100 text-gray-500 rounded']) }}>
    <svg wire:loading xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
        <path fill="#222" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z">
            <animateTransform attributeName="transform" dur="0.9s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
        </path>
    </svg>
    <span>
        {{ $slot }}
    </span>
</button>