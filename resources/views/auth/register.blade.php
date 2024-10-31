<x-guest-layout>
    <div class="flex h-full sm:justify-center lg:justify-center md:justify-center items-center">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
            <div class="flex h-full justify-center items-center sm:px-5 sm:py-12 md:px-10 md:py-24 lg:px-20 lg:-mr-14">
                <form action="{{ route('register') }}" method="POST" class="border border-slate-300 rounded py-6 px-7 w-full">
                    @csrf
                    <h3 class="font-bold text-2xl">SIGN UP</h3>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div class="">
                        <div class="mt-3">
                            <x-forms.text-input-icon style="width: 100%;" type="text" name="name" placeholder="User Name" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <div class="mt-3">
                            <x-forms.text-input-icon type="email" name="email" placeholder="Email Address" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1_4773)">
                                        <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 6L12 13L2 6" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1_4773">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <div class="mt-3">
                            <x-forms.text-input-icon type="password" name="password" placeholder="Password" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <div class="mt-3">
                            <x-forms.text-input-icon type="password" name="password_confirmation" placeholder="Confirm Password" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <div class="mt-3">
                            <x-forms.select-input name="role">
                                <option disabled selected>Select User Type</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ __(Str::ucfirst($role->name)) }}</option>
                                @endforeach
                            </x-forms.select-input>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="flex gap-4">
                            <x-forms.checkbox-input name="remember" />
                            <span class="text-sm text-gray-700">
                                {{ __('I accept terms and conditions') }}
                            </span>
                        </p>
                    </div>

                    <div class="mt-3">
                        <x-buttons.primary class="w-full">
                            SIGN UP
                        </x-buttons.primary>
                    </div>

                    <div class="mt-2 text-center">
                        <span>Or</span>
                    </div>

                    <div class="mt-2">
                        <a href="#" class="inline-block border border-slate-200 rounded-lg p-3 w-full text-center">
                            <img class="inline-block" src="{{ asset('assets/icons/goolge-logo.png') }}" alt="google">
                            <span class="pl-2 sm:hidden md:inline-block text-center">Sign up with Google</span>
                            <span class="pl-2 md:hidden">Sign up</span>
                        </a>
                    </div>

                    <div class="mt-3">
                        <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                            {{ __('Already have an account ?') }}
                            <a href="{{ route('login') }}" class="text-primary-400 underline font-bold">Sign In</a>.
                        </p>
                    </div>
                </form>
            </div>

            <div class="sm:hidden md:hidden lg:block relative">
                <div class="flex justify-center items-center h-full">
                    <img src="{{ asset('assets/images/signup.png') }}" alt="signup">
                    <div class="absolute top-20 left-12 pe-14">
                        <h3 class="font-inter text-2xl font-semibold">Welcome Back !</h3>
                        <p class="font-inter text-sm font-normal text-black-400"><span class="!text-primary-400 !font-semibold">LogmyRequest</span>
                            is a customer service platform designed to help businesses efficiently track, manage, and resolve customer requests in real time. Our mission is to streamline communication and ensure every query is addressed promptly, enhancing customer satisfaction.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
