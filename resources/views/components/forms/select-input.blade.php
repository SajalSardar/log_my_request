<select {!! $attributes->merge(['class' => 'w-full py-2 border border-[#dddddd] text-title focus:border-primary-400 rounded bg-transparent']) !!}>
    {{ $slot }}
</select>