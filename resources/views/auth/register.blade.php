<x-guest-layout>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
        <div class="flex p-20 bg-red-500 border border-slate-300">
            <form action="">
                <div class="flex w-full">
                    <x-forms.text-input-icon type="text" name="name" placeholder="User Name"
                        dir="start">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </x-forms.text-input-icon>
                </div>

            </form>
        </div>

        <div>
            <img src="{{ asset('assets/images/signup.png') }}" alt="">
        </div>
    </div>
</x-guest-layout>