<select {!! $attributes->merge(['class' => 'select2 w-full focus:ring-primary-400 focus:border-primary-400 dark:focus:ring-primary-400 dark:focus:border-primary-400 text-paragraph']) !!}>
    {{ $slot }}
</select>