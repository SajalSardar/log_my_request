<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'hover:bg-primary-400 hover:text-gray-100 border border-slate-200 px-8 py-2 bg-gray-100 text-gray-500 rounded']) }}>
    {{ $slot }}
</button>
