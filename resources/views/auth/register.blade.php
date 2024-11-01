<x-guest-layout>
    <div class="flex h-full sm:justify-center lg:justify-center md:justify-center items-center">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
            <div class="flex h-full justify-center items-center sm:px-5 sm:py-12 md:px-10 md:py-24 lg:px-20 lg:-mr-14">
                <form action="{{ route('register') }}" method="POST" class="border border-base-500 rounded p-6 w-full">
                    @csrf
                    <h3 class="font-semibold font-inter text-[#333] text-[28px] mb-6">SIGN UP</h3>
                    <x-auth-session-status class="mb-6" :status="session('status')" />
                    <div class="">
                        <div class="mt-3">
                            <x-forms.text-input-icon style="width: 100%;" type="text" name="name" placeholder="User Name" dir="start">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z" stroke="#5C5C5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="#5C5C5C" stroke-width="1.5" />
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
                                <option class="text-paragraph" disabled selected>Select User Type</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ __(Str::ucfirst($role->name)) }}</option>
                                @endforeach
                            </x-forms.select-input>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="flex items-center gap-2">
                            <x-forms.checkbox-input name="remember" />
                            <span class="text-sm text-gray-700">
                                {{ __('I accept terms and conditions') }}
                            </span>
                        </p>
                    </div>

                    <div class="mt-3">
                        <x-buttons.primary class="w-full font-inter font-semibold text-base text-[#5c5c5c]">
                            SIGN UP
                        </x-buttons.primary>
                    </div>

                    <div class="mt-2 text-center">
                        <span class="text-paragraph">Or</span>
                    </div>

                    <div class="mt-2">
                        <a href="#" class="inline-block border border-base-500 rounded-lg p-3 w-full text-center">
                            <svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect x="3" y="3" width="18" height="18" fill="url(#pattern0_810_3051)" />
                                <defs>
                                    <pattern id="pattern0_810_3051" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_810_3051" transform="scale(0.0416667)" />
                                    </pattern>
                                    <image id="image0_810_3051" width="24" height="24"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAsQAAALEBxi1JjQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAMvSURBVEiJpZZPbBR1FMc/b2a2LFIrWStr1/4xFBaNtF404WAjGkVZLZ4kG9ISPRqMhoPeUKBEExNivWqIMS1Gi8R/SbVEYgnBpMFoQimHlt2YiEvZtgvVXVncmXkeaJud2dndJnyTubzve5/3e/ll3oxQQ/r8Qw9iuEmEJ4FuIHI5b4cNoRQSboSEsyHL/KD51MxENYYEghMPd2C476GaBIxybzpf8gIE7jJlOozV13x6+ryfZfgDmti8B3EuoLonyK/IVyjYGr/hlCZmn9n4fs0JNBHfj3C02mRBE/hh98ut+5rGM/MVE+gL8WQdeAY4Gza4bonYQQmNljFeDl+ZQF/qbMM2J4F7fDWKMoS6g/LD5d/LjeyzGxP/uXxYsDUOcHfIOBP7KbU9aCr0vHmMk9HNTDY+DoSXvDyqr8jozMkqE91utKPzDXU0Hj2dfj3IF71EB0oKMMlZV/i0Nc21hh5U+2R05vNa8FVJL/G2TqGe5+t1g3cMXpKF8lRFdFNhuFZR5OBCk1PMm/Xgi+H2f0Sn+BNoLYtn5BEeqFa04UCmD2GoHnxJvxhAsy+YqlUh0L5KOEBX3Tf1DtVgAPO+YGetChfc1fNlwQIm8d5BTCd5TLr4NbBEzRMYdhuI5Ym7tKqQ8GbrlIUwjrKzPPyHs64fCoENskeiKWCfP77h3cxnqO8wcEZ0inYgDZi2ypUDC1vSH//d0aNo//XeU8eDR/cq+s5fvYp8i3ePuWo4WwSgeNH45Pt/o5venNu6regay6uigMiruRd/PLEK+JfAWo+hfJUdiL0sAJHRna047kUClp3CsAmD871jv5Ub648/3S+lNa+F0se2UbmB82KYj147GE2vGJHvntuN8EVA8rKuAilnrtgtjjaqe3vVW07PtDm7L+45u7I3OxAbhrLvQW7X2AiwH/xXtaIW4AlK2rQMB7AbznVi5W+uwJG3luGeBgC53rGPUJLAYpUmlXJcsxQ7NAssqkoye7jlaLld8Sbndo2N4GiXwhDg1G0g4IZmi7bhbp0baBkJsKsr8s2ONjWNpOBuB+kGvde5WlyLiCOW5DCZMJEjC3t/rvrb8j9aeDScVZZt1AAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                            <span class="pl-2 sm:hidden md:inline-block text-center text-paragraph">Sign up with Google</span>
                            <span class="pl-2 md:hidden">Sign up</span>
                        </a>
                    </div>

                    <div class="mt-2">
                        <p class="text-paragraph sm:mt-0">
                            {{ __('Already have an account ?') }}
                            <a href="{{ route('login') }}" class="text-primary-400 underline font-bold">Sign In</a>.
                        </p>
                    </div>
                </form>
            </div>

            <div class="sm:hidden md:hidden lg:block relative">
                <div class="flex justify-center items-center h-full">
                    <img src="{{ asset('assets/images/login-register.png') }}" alt="signup">
                    <div class="absolute top-20 left-12 pe-14">
                        <h3 class="font-inter text-2xl font-semibold text-[#333]">Welcome Back!</h3>
                        <p class="text-title">
                            <span class="!text-primary-400 !font-semibold">LogmyRequest</span>
                            is a customer service platform designed to help businesses efficiently track, manage, and resolve customer requests in real time. Our mission is to streamline communication and ensure every query is addressed promptly, enhancing customer satisfaction.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>