<select {!! $attributes->merge(['class' => 'w-full py-1 border border-slate-400 text-black-400 focus:border-primary-400 rounded-lg bg-transparent']) !!}>
    {{ $slot }}
</select>