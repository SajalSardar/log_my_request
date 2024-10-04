<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-primary-400 text-white rounded px-8 py-2']) }}>
    {{ $slot }}
</button>
