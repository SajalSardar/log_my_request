<nav class="flex pb-3 text-gray-700 " aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium font-inter text-black-400">
                Dashboard
            </a>
            @if (!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium font-inter text-black-400">
                    /
                </a>
            @endif
            <a href="javascript:;" class="inline-flex items-center text-sm font-normal font-inter text-black-400">
                {{ $slot }}
            </a>
        </li>
    </ol>
</nav>