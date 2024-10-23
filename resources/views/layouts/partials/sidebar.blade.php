<div class="fixed left-0 top-0 w-64 h-full bg-white py-5 z-50 sidebar-menu transition-transform"
    style="border-right: 1px solid #cfcece">
    <a href="#" class="flex items-center justify-center pb-4">
        <img src="{{ asset('assets/icons/EventMetro.png') }}" alt="logo">
    </a>

    <ul class="mt-3 bg-primary-500 h-full">
        <li class="group pl-4 relative">


            <a href="{{ route('dashboard') }}"
                class="flex text-sm py-2 items-center text-gray-900 hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-xl before:content-[''] before:w-[2px] before:h-[35px] before:top-0 {{ Route::is('dashboard') ? 'font-semibold bg-orange-100 before:bg-primary-400' : '' }}">
                <span class="pl-1 flex items-center text-sm items-center text-gray-900">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#6D4DFF">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span class="font-inter text-sm  ml-1">Dashboard</span>
            </a>
            </span>
        </li>
        @foreach (Helper::getAllMenus() as $menu)
            @php
                $subMenuRouts = $menu->submneus->pluck('route')->toArray();

                $sbMenu = [];
                foreach ($subMenuRouts as $key => $subMenuRout) {
                    $exMenu = explode('.', $subMenuRout);
                    array_pop($exMenu);
                    $exnew = join('.', $exMenu);
                    $sbMenu[] = $exnew . '.*';
                }
            @endphp
            <li class="group  pl-4 relative {{ Route::is($sbMenu) ? 'selected' : '' }} ">
                <a href=" {{ $menu->route == '#' ? '#' : ($menu->url ? url($menu->url) : route($menu->route)) }}"
                    class="block py-2 text-sm items-center text-gray-900 hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-xl before:content-[''] before:w-[2px] before:h-[35px] before:top-0 {{ Route::is($menu->route) || Route::is($sbMenu) || url($menu->url) == Request::fullUrl() ? 'font-semibold bg-orange-100 before:bg-primary-400' : '' }} {{ count($menu->submneus) > 0 ? 'sidebar-dropdown-toggle' : '' }} ">

                    <span class="flex items-center text-sm">
                        <span class="pl-1">{!! $menu->icon !!}</span>
                        <span class="font-inter  ml-1">{{ $menu->name }}</span>
                    </span>
                </a>
                @if (count($menu->submneus) > 0)
                    <ul class="ml-3 mt-2 hidden group-[.selected]:block">
                        @foreach ($menu->submneus as $submenu)
                            <li class="relative">
                                <a href="{{ $submenu->route == '#' && $submenu->url ? url($submenu->url) : route($submenu->route) }}"
                                    class="pl-1 py-2 px-2 text-gray-900 font-inter text-sm flex items-center block hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-xl before:content-[''] before:w-[2px] before:h-full before:top-0 before:left-0 {{ Route::is($submenu->route) || url($submenu->url) == Request::fullUrl() ? 'font-semibold bg-orange-100 before:bg-primary-400' : '' }}">

                                    <span class="flex items-center">
                                        <span class="pl-1"> {!! $submenu->icon !!}</span>
                                        <span class="font-inter ml-1">{{ $submenu->name }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
