<x-app-layout>
    @section('title', 'Profile')
    @section('breadcrumb')
    <x-breadcrumb>
        Update Profile
    </x-breadcrumb>

    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        <div>
            <h3 class="text-heading-dark">Profile Settings</h3>
            <div class="w-full h-[2px] bg-[#ddd] mt-5"></div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        <div class="flex justify-evenly  py-6">
            <div class="flex gap-3 items-center">
                <img src="{{ asset('assets/images/pro.png') }}" alt="" class="w-[72px] h-[72px]">
                <div>
                    <h3 class="text-heading-dark">Marvin McKinney</h3>
                    <p class="text-paragraph">Product Designer</p>
                </div>
            </div>
            <div>
                <input id="changeImage" hidden type="file">
                <x-buttons.secondary for="changeImage" type="button">
                    Change Image
                </x-buttons.secondary>
                <div class="text-paragraph pt-1 text-center">
                    <span>PNG,JPG Upto 10 MB</span>
                </div>
            </div>
        </div>
    </div>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        <div class="w-full h-[2px] bg-[#ddd]"></div>
    </div>

</x-app-layout>

<!-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        @include('profile.partials.update-profile-information-form')
    </div>
</div>

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        @include('profile.partials.update-password-form')
    </div>
</div> -->