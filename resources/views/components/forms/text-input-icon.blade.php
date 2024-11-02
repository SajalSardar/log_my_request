<div class="relative">
    <input style="height: 40px;" type="{{ $type }}" {!! $attributes->merge([
    'class' => 'text-paragraph w-full ps-10 border border-[#dddddd] focus:ring-primary-400 focus:border-primary-400 dark:focus:ring-primary-400 dark:focus:border-primary-400 rounded-lg bg-transparent',
]) !!} />
    <span class="absolute inset-y-0 {{ $dir }}-0 grid w-10 place-content-center">
        <button type="button" class="text-gray-600 hover:text-gray-700">
            {{ $slot }}
        </button>
    </span>
</div>