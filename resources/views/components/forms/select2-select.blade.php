<select {!! $attributes->merge(['class' => 'select2 w-full focus:border-primary-400 text-base font-medium font-inter']) !!}>
    {{ $slot }}
</select>
