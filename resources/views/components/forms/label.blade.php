<label {!! $attributes->merge(['class' => 'text-sm font-medium pb-1 block']) !!}>
    {{ $slot }}
    <span class="text-red-500">
        @if ($required == 'yes')
            *
        @endif
    </span>
</label>
