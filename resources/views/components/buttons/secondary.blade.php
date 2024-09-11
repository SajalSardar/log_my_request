<button {{ $attributes->merge(['type' => 'submit', 'class' => 'border border-slate-500 px-8 py-2 bg-transparent text-zinc-400 rounded']) }}>
    {{ $slot }}
</button>
