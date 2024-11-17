<div class="navbar sticky border z-10 border-b-base-500">
    <div class="navbar-wrapper flex justify-between">
        <div class="hamberger">
            <button type="button" class="text-lg text-gray-900 font-semibold sidebar-toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 5H14" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4 12H20" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4 19H20" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <div class="flex gap-6 items-center mr-6">
            <div class="relative cursor-pointer mr-2 toggle-notification-button">
                <svg width="24" height="24" class="sm:w-5 sm:h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="#5c5c5c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21" stroke="#5c5c5c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="md:w-5 md:h-5 sm:w-4 sm:h-4 bg-[#ef4444] rounded-full text-center text-white text-xs absolute -top-2 -end-2">
                    {{ getTicketNotsNotify()->count() }}
                    <div class="absolute top-0 start-0 rounded-full -z-10 bg-[#ef4444] w-full h-full"></div>
                </div>

                <div class="toggle-notification-box absolute w-96 h-96 bg-white border border-slate-300 rounded shadow top-12 right-0 sm:-right-10 overflow-auto" style="display: none">
                    @forelse (getTicketNotsNotify()->take(30) as $item)
                    <a href="{{ route('admin.ticket.show',[$item->ticket_id, 'notify_id' =>$item->id ]) }}">
                        <div class="p-4 flex items-center hover:bg-slate-200">
                            <div class="ml-4">
                                @php
                                $replaceString = str_replace('_'," ", $item->note_type)
                                @endphp
                                <p class="text-sm text-gray-500">{{ Str::ucfirst($replaceString) }}</p>
                                <p class="text-sm text-gray-500">{{ date('l h:i:a d M, Y', strtotime($item->created_at)) }}</p>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="p-4 flex items-center hover:bg-slate-200">
                        <div class="ml-4">
                            <p>Notification not found!</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="relative">
                <div class="toggle-menu-button flex gap-1 items-center cursor-pointer">
                    <img src="{{ Auth::user()->image?->url ? Auth::user()->image?->url : asset('assets/images/profile.png') }}" alt="profile" width="38" width="38" style="border-radius: 50%">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="toggle-menu absolute p-3 shadow w-[180px] rounded bg-white sm:right-12 z-50" style="top: 46px;display:none">
                    <ul>
                        <li class="py-2 cursor-pointer">
                            <p href="#" class="text-title">
                                {{ Auth::user()->name }}
                            </p>
                        </li>
                        <li class="py-2 cursor-pointer">
                            <a href="{{ route('profile.edit') }}" class="text-title">Profile</a>
                        </li>
                        <li class="py-2 cursor-pointer">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-transparent text-title">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Define method changeLanguage to change the local language
     * @param lang 
     */
    function changeLanguage(lang) {
        window.location.href = "{{ url('locale') }}/" + lang;
    }
</script>