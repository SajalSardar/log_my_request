<div class="fixed left-0 top-0 w-64 h-full bg-white py-5 z-50 sidebar-menu transition-transform"
    style="border-right: 1px solid #cfcece">
    <a href="#" class="flex items-center justify-center pb-4">
        <img src="{{ asset('assets/icons/EventMetro.png') }}" alt="logo">
    </a>

    <ul class="mt-3 bg-primary-500 h-full">
        <li class="group pb-2 pt-4 px-5 relative">
            <span
                class="flex items-center {{ Route::is('dashboard') ? 'font-semibold before:absolute before:rounded-l-xl before:content-[""] before:w-[4px] before:h-full before:bg-primary-400 before:top-0 before:right-0' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M2 18C2 16.4596 2 15.6893 2.34673 15.1235C2.54074 14.8069 2.80693 14.5407 3.12353 14.3467C3.68934 14 4.45956 14 6 14C7.54044 14 8.31066 14 8.87647 14.3467C9.19307 14.5407 9.45926 14.8069 9.65327 15.1235C10 15.6893 10 16.4596 10 18C10 19.5404 10 20.3107 9.65327 20.8765C9.45926 21.1931 9.19307 21.4593 8.87647 21.6533C8.31066 22 7.54044 22 6 22C4.45956 22 3.68934 22 3.12353 21.6533C2.80693 21.4593 2.54074 21.1931 2.34673 20.8765C2 20.3107 2 19.5404 2 18Z"
                        stroke="#6D4DFF" stroke-width="1.5" />
                    <path
                        d="M14 18C14 16.4596 14 15.6893 14.3467 15.1235C14.5407 14.8069 14.8069 14.5407 15.1235 14.3467C15.6893 14 16.4596 14 18 14C19.5404 14 20.3107 14 20.8765 14.3467C21.1931 14.5407 21.4593 14.8069 21.6533 15.1235C22 15.6893 22 16.4596 22 18C22 19.5404 22 20.3107 21.6533 20.8765C21.4593 21.1931 21.1931 21.4593 20.8765 21.6533C20.3107 22 19.5404 22 18 22C16.4596 22 15.6893 22 15.1235 21.6533C14.8069 21.4593 14.5407 21.1931 14.3467 20.8765C14 20.3107 14 19.5404 14 18Z"
                        stroke="#6D4DFF" stroke-width="1.5" />
                    <path
                        d="M2 6C2 4.45956 2 3.68934 2.34673 3.12353C2.54074 2.80693 2.80693 2.54074 3.12353 2.34673C3.68934 2 4.45956 2 6 2C7.54044 2 8.31066 2 8.87647 2.34673C9.19307 2.54074 9.45926 2.80693 9.65327 3.12353C10 3.68934 10 4.45956 10 6C10 7.54044 10 8.31066 9.65327 8.87647C9.45926 9.19307 9.19307 9.45926 8.87647 9.65327C8.31066 10 7.54044 10 6 10C4.45956 10 3.68934 10 3.12353 9.65327C2.80693 9.45926 2.54074 9.19307 2.34673 8.87647C2 8.31066 2 7.54044 2 6Z"
                        stroke="#6D4DFF" stroke-width="1.5" />
                    <path
                        d="M14 6C14 4.45956 14 3.68934 14.3467 3.12353C14.5407 2.80693 14.8069 2.54074 15.1235 2.34673C15.6893 2 16.4596 2 18 2C19.5404 2 20.3107 2 20.8765 2.34673C21.1931 2.54074 21.4593 2.80693 21.6533 3.12353C22 3.68934 22 4.45956 22 6C22 7.54044 22 8.31066 21.6533 8.87647C21.4593 9.19307 21.1931 9.45926 20.8765 9.65327C20.3107 10 19.5404 10 18 10C16.4596 10 15.6893 10 15.1235 9.65327C14.8069 9.45926 14.5407 9.19307 14.3467 8.87647C14 8.31066 14 7.54044 14 6Z"
                        stroke="#6D4DFF" stroke-width="1.5" />
                </svg>

                <a href="{{ route('dashboard') }}"
                    class="flex text-sm items-center text-gray-900 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                    <i class="ri-home-2-line text-lg"></i>
                    <span class="font-inter text-sm  ml-1">Dashboard</span>
                </a>
            </span>
        </li>
        @foreach (Helper::getAllMenus() as $menu)

            @if (Helper::roleWiseMenuPermission($menu->id))
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
                <li class="group py-2 pl-5 relative {{ Route::is($sbMenu) ? 'selected' : '' }} ">
                    <a href="{{ $menu->route == '#' ? '#' : route($menu->route) }}" style="display: inline"
                        class="flex text-sm items-center text-gray-900 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white {{ count($menu->submneus) > 0 ? 'sidebar-dropdown-toggle' : '' }} ">

                        <span
                            class="flex items-center text-sm {{ Route::is($menu->route) ? 'font-semibold before:absolute before:rounded-l-xl before:content-[""] before:w-[4px] before:h-full before:bg-primary-400 before:top-0 before:right-0' : '' }}">
                            {!! $menu->icon !!}
                            <span class="font-inter  ml-1">{{ $menu->name }}</span>
                        </span>
                    </a>
                    @if (count($menu->submneus) > 0)
                        <ul class="pl-1 mt-2 hidden group-[.selected]:block">
                            @foreach ($menu->submneus as $submenu)
                                {{-- @php
                                    $submenuRoute = '';
                                    $exsubmenuRoute = explode('.', $submenu->route);
                                    array_pop($exsubmenuRoute);
                                    $exsubmenuRoutenew = join('.', $exsubmenuRoute);

                                    $submenuRoute = $exsubmenuRoutenew . '.*';
                                    echo $submenuRoute . PHP_EOL;
                                    echo Route::currentRouteName() . PHP_EOL;
                                    echo $submenu->route;
                                @endphp --}}
                                @if (Helper::roleWiseMenuPermission($submenu->id))
                                    <li class="py-2 px-2 flex relative">
                                        <a href="{{ $submenu->route == '#' && $submenu->url ? url($submenu->url) : route($submenu->route) }}"
                                            class="pl-1 text-gray-900 font-inter text-sm flex items-center hover:text-[#f84525]">

                                            <span
                                                class="flex items-center {{ Route::is($submenu->route) || url($submenu->url) == Request::fullUrl() ? 'font-semibold before:absolute before:rounded-l-xl before:content-[""] before:w-[4px] before:h-full before:bg-primary-400 before:top-0 before:right-0' : '' }}">
                                                {!! $submenu->icon !!}
                                                <span class="font-inter ml-1">{{ $submenu->name }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
