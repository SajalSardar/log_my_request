<select style="height: 40px;" {!! $attributes->merge(['class' => 'w-full border border-[#dddddd] text-title focus:border-primary-400 rounded bg-transparent']) !!}>
    {{ $slot }}
</select>