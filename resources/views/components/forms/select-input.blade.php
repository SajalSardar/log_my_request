<select {!! $attributes->merge(['class' => 'w-full py-3 border border-slate-400 text-slate-400 focus:border-primary-400 rounded-lg bg-transparent']) !!}>
    {{ $slot }}
</select>
