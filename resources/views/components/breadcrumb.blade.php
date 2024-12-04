<ul class="flex gap-x-1 items-center mb-8">
    @isset($data)
        @foreach ($data as $key => $item)
            <li>
                <a href="{{ $item['route'] }}" class="flex items-center text-title">
                    <span @if($loop->last) class="text-primary-400" @endif>
                        {{ $item['title'] }}
                    </span>
                </a>
            </li>
        @endforeach
    @endisset
</ul>