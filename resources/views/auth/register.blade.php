<x-guest-layout>
    <section class="bg-white border border-slate-400 lg:rounded-3xl sm:rounded-none">
        <div class="lg:grid sm:h-[885px] h-[500px] lg:grid-cols-12">
            <section
                class="relative sm:hidden md:hidden lg:block xl:block flex h-full items-end lg:col-span-5 lg:h-full xl:col-span-6">
                <img alt="" src="{{ asset('assets/images/login-page-image.png') }}"
                    class="absolute lg:rounded-l-3xl sm:rounded-none inset-0 h-full w-full object-fit opacity-80" />
            </section>

            <main class="flex items-center justify-center py-8 sm:px-0 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
                <div class="max-w-xl lg:max-w-3xl border border-slate-200 rounded-lg p-12">
                    <h3 class="font-bold text-2xl">SIGN UP</h3>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('register') }}" class="mt-8 grid grid-cols-6 gap-6">
                        @csrf
                        <div class="col-span-6 sm:col-span-3">
                            <a href="#" class="inline-block border border-slate-200 rounded-lg p-3 w-full">
                                <img class="inline-block" src="{{ asset('assets/icons/goolge-logo.png') }}"
                                    alt="google">
                                <span class="pl-2 sm:hidden md:inline-block text-center">Sign in with Google</span>
                                <span class="pl-2 md:hidden">Sign In</span>
                            </a>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <a href="#" class="inline-block border border-slate-200 rounded-lg p-3 w-full">
                                <img class="inline-block" src="{{ asset('assets/icons/facebook-logo.png') }}"
                                    alt="facebook">
                                <span class="pl-2 sm:hidden md:inline-block text-center">Sign in with Facebook</span>
                                <span class="pl-2 md:hidden">Sign In</span>
                            </a>
                        </div>

                        <div class="col-span-6 text-center">
                            <span>Or Email</span>
                        </div>

                        <div class="col-span-6">
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
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="col-span-6">
                            <x-forms.text-input-icon type="email" name="email" placeholder="Email Address"
                                dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1_4773)">
                                        <path
                                            d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                                            stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 6L12 13L2 6" stroke="#666666" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
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

                        <div class="col-span-6">
                            <x-forms.text-input-icon type="password" name="password" placeholder="Password"
                                dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z"
                                        stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11"
                                        stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="col-span-6">
                            <x-forms.text-input-icon type="password" name="password_confirmation"
                                placeholder="Confirm Password" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z"
                                        stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11"
                                        stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </x-forms.text-input-icon>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="col-span-6">
                            <x-forms.select-input name="role">
                                <option disabled selected>Select User Type</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ __(Str::ucfirst($role->name)) }}</option>
                                @endforeach
                            </x-forms.select-input>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="col-span-6 flex justify-between">
                            <p class="flex gap-4">
                                <x-forms.checkbox-input name="remember" />
                                <span class="text-sm text-gray-700">
                                    {{ __('I accept terms and conditions') }}
                                </span>
                            </p>
                        </div>

                        <div class="col-span-6">
                            <x-buttons.primary class="w-full">
                                SIGN UP
                            </x-buttons.primary>
                        </div>

                        <div class="col-span-6">
                            <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                                {{ __('Already have an account ?') }}
                                <a href="{{ route('login') }}" class="text-primary-400 underline font-bold">Sign
                                    In</a>.
                            </p>
                        </div>

                    </form>
                </div>
            </main>
        </div>
    </section>
</x-guest-layout>
