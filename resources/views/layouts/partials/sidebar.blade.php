<div class="fixed left-0 top-0 w-[276px] h-full bg-white py-5 z-50 sidebar-menu transition-transform" style="border-right: 1px solid #cfcece">
    <a href="javascript:;" class="flex items-center justify-center pb-4">
        <img src="{{ asset('assets/icons/logMyRequest.png') }}" alt="logo">
    </a>

    <ul class="mt-3 bg-white h-full">
        <li class="group pl-6 relative">
            <a href="{{ route('dashboard') }}" class="flex py-4 items-center hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-2xl before:content-[''] before:w-[3px] before:h-[55px] before:top-0 {{ Route::is('dashboard') ? '!font-semibold bg-orange-100 before:bg-primary-400' : 'font-normal' }}">
                <span class="pl-4 flex items-center text-sm font-inter font-semibold {{ Route::is('dashboard') ? 'text-[#333]' : 'text-[#5c5c5c]'}}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5 15.5C13.5 14.5572 13.5 14.0858 13.7929 13.7929C14.0858 13.5 14.5572 13.5 15.5 13.5H20C20.9428 13.5 21.4142 13.5 21.7071 13.7929C22 14.0858 22 14.5572 22 15.5V20C22 20.9428 22 21.4142 21.7071 21.7071C21.4142 22 20.9428 22 20 22H15.5C14.5572 22 14.0858 22 13.7929 21.7071C13.5 21.4142 13.5 20.9428 13.5 20V15.5Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2 4C2 3.05719 2 2.58579 2.29289 2.29289C2.58579 2 3.05719 2 4 2H8.5C9.44281 2 9.91421 2 10.2071 2.29289C10.5 2.58579 10.5 3.05719 10.5 4V8.5C10.5 9.44281 10.5 9.91421 10.2071 10.2071C9.91421 10.5 9.44281 10.5 8.5 10.5H4C3.05719 10.5 2.58579 10.5 2.29289 10.2071C2 9.91421 2 9.44281 2 8.5V4Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2 15.5C2 14.5572 2 14.0858 2.29289 13.7929C2.58579 13.5 3.05719 13.5 4 13.5H8.5C9.44281 13.5 9.91421 13.5 10.2071 13.7929C10.5 14.0858 10.5 14.5572 10.5 15.5V20C10.5 20.9428 10.5 21.4142 10.2071 21.7071C9.91421 22 9.44281 22 8.5 22H4C3.05719 22 2.58579 22 2.29289 21.7071C2 21.4142 2 20.9428 2 20V15.5Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.5 4C13.5 3.05719 13.5 2.58579 13.7929 2.29289C14.0858 2 14.5572 2 15.5 2H20C20.9428 2 21.4142 2 21.7071 2.29289C22 2.58579 22 3.05719 22 4V8.5C22 9.44281 22 9.91421 21.7071 10.2071C21.4142 10.5 20.9428 10.5 20 10.5H15.5C14.5572 10.5 14.0858 10.5 13.7929 10.2071C13.5 9.91421 13.5 9.44281 13.5 8.5V4Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="font-inter text-sm  ml-2">Dashboard</span>
                </span>
            </a>
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
                <li class="group pl-6 relative {{ Route::is($sbMenu) ? 'selected' : '' }} ">
                    @if ($menu->route !== 'logout')
                        <a href=" {{ $menu->route == '#' ? '#' : ($menu->url ? url($menu->url) : route($menu->route)) }}" class="block py-4 text-sm font-inter text-[#333] hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-2xl before:content-[''] before:w-[3px] before:h-[55px] before:top-0 {{ Route::is($menu->route) || Route::is($sbMenu) || url($menu->url) == Request::fullUrl() ? '!font-semibold bg-orange-100 before:bg-primary-400' : '' }} {{ count($menu->submneus) > 0 ? 'sidebar-dropdown-toggle' : '' }}">

                            <span class="flex items-center text-sm font-inter font-semibold text-[#333]">
                                <span class="pl-4">{!! $menu->icon !!}</span>
                                <span class="font-inter  ml-2">{{ $menu->name }}</span>
                            </span>
                    @endif
                    </a>
                    @if ($menu->route == 'logout')
                        <form action="{{ route('logout') }}" method="POST" class="block py-4 text-sm font-inter text-[#333] hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-2xl before:content-[''] before:w-[3px] before:h-[55px] before:top-0 {{ Route::is($menu->route) || Route::is($sbMenu) || url($menu->url) == Request::fullUrl() ? '!font-semibold bg-orange-100 before:bg-primary-400' : '' }} {{ count($menu->submneus) > 0 ? 'sidebar-dropdown-toggle' : '' }} ">
                            @csrf
                            <button type="submit" class="flex items-center text-sm font-inter font-semibold text-[#333]">
                                <span class="pl-4">{!! $menu->icon !!}</span>
                                <span class="font-inter  ml-2">{{ $menu->name }}</span>
                            </button>
                        </form>
                    @endif

                    @if (count($menu->submneus) > 0)
                        <ul class="ml-3 hidden group-[.selected]:block">
                            @foreach ($menu->submneus as $submenu)
                                <li class="relative">
                                    <a href="{{ $submenu->route == '#' && $submenu->url ? url($submenu->url) : route($submenu->route) }}" class="pl-2 px-2 text-[#333] py-4 font-inter text-sm flex items-center block hover:bg-orange-100 hover:before:bg-primary-400 before:absolute before:rounded-r-2xl before:content-[''] before:w-[3px] before:h-full before:top-0 before:left-0 {{ Route::is($submenu->route) || url($submenu->url) == Request::fullUrl() ? 'font-semibold bg-orange-100 before:bg-primary-400' : '' }}">

                                        <span class="flex items-center text-sm font-inter font-semibold text-[#333]">
                                            <span class="pl-4"> {!! $submenu->icon !!}</span>
                                            <span class="font-inter ml-2">{{ $submenu->name }}</span>
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