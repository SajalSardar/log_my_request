<select style="height: 40px;" {!! $attributes->merge(['class' => 'w-full border-base-500 focus:ring-primary-400 focus:border-primary-400 dark:focus:ring-primary-400 dark:focus:border-primary-400 rounded bg-transparent text-paragraph']) !!}>
    {{ $slot }}
</select>

<style>
    select>option {
        background-color: white;
        color: #333;
    }
</style>