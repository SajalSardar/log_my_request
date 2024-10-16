<div>
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-5">
        <div class="col-span-2 mt-3">
            <div class="mt-3 py-4">
                <form action="{{ route('admin.ticket.conversation',['ticket' => $ticket?->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <textarea cols="30" id="conversation" rows="10" name='conversation'
                            class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                            placeholder="Conversation here.."></textarea>
                        <x-input-error :messages="$errors->get('conversation')" class="mt-2" />
                    </div>
                    <!-- <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                        <div class="p-2 w-full">
                            <x-forms.input-file name="request_attachment" accept=".pdf,.docs,.ppt" />
                            <x-input-error :messages="$errors->get('request_attachment')" class="mt-2" />
                        </div>
                    </div> -->
                    <div class="text-right">
                        <x-buttons.primary class="mt-2 ml-auto">
                            Send
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>

        <div class="row-span-2">
            <div class="flex gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.59 13.41L13.42 20.58C13.2343 20.766 13.0137 20.9135 12.7709 21.0141C12.5281 21.1148 12.2678 21.1666 12.005 21.1666C11.7422 21.1666 11.4819 21.1148 11.2391 21.0141C10.9963 20.9135 10.7757 20.766 10.59 20.58L2 12V2H12L20.59 10.59C20.9625 10.9647 21.1716 11.4716 21.1716 12C21.1716 12.5284 20.9625 13.0353 20.59 13.41V13.41Z" stroke="#3D3D3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 7H7.01" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="font-inter font-semibold text-base">Request Information</h3>
            </div>

            <div class="border border-slate-200 rounded px-24 py-5 mt-3">
                <div class="flex justify-center">
                    <img src="{{asset('assets/images/profile.jpg')}}" width="100" height="100" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                </div>
                <div class="mt-5">
                    <ul>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Request: </span>
                            <span class="font-sm font-normal font-inter">{{ $ticket?->user?->name }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">ID:
                            </span>
                            <span class="font-sm font-normal font-inter">#{{ $ticket?->user->id }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Email: </span>
                            <span class="font-sm font-normal font-inter">{{ $ticket?->user?->email }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Title: </span>
                            <span class="font-sm font-normal font-inter">{{ $ticket?->title }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Priority: </span>
                            <span class="font-sm font-normal font-inter">{{ ucfirst($ticket?->priority) }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Requester Type: </span>
                            <span class="font-sm font-normal font-inter">{{ $ticket?->user->requester_type?->name }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="font-sm font-semibold font-inter">Created at: </span>
                            <span class="font-sm font-normal font-inter">{{ Helper::ISOdate($ticket?->created_at)}}</span>
                        </li>
                    </ul>

                    <x-buttons.primary class="!bg-closed-400">
                        Close Ticket &times;
                    </x-buttons.primary>
                </div>
            </div>
        </div>

        <div class="col-span-2 border border-slate-200 p-4 rounded">
            <div class="mb-4">
                <p class="mb-4">Sunday,15 Oct, 2024</p>
                <div class="flex items-center gap-2">
                    <img src="{{asset('assets/images/profile.jpg')}}" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                    <p class="text-base font-semibold font-inter">{{ $ticket->user->name }}</p>
                </div>
                <div class="-mt-2">
                    <div class="pl-14 -mt-3 flex gap-2">
                        <!-- Added flex, items-center, and gap classes -->
                        <div class="pt-2">
                            <p class="text-base font-normal font-inter inline-block">
                                I'm having trouble accessing my student portal. I keep getting an error message saying "Access Denied."
                            </p>
                        </div>
                        <span class="flex items-center gap-x-2 -top-2">
                            <p>3:40 pm</p>
                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <p class="mb-4">Sunday,15 Oct, 2024</p>
                <div class="flex items-center gap-2">
                    <img src="{{asset('assets/images/profile.jpg')}}" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                    <p class="text-base font-semibold font-inter">{{ $ticket->user->name }}</p>
                </div>
                <div class="-mt-2">
                    <div class="pl-14 -mt-3 flex gap-2">
                        <!-- Added flex, items-center, and gap classes -->
                        <div class="pt-2">
                            <p class="text-base font-normal font-inter inline-block">
                                I'm having trouble accessing my student portal. I keep getting an error message saying "Access Denied."
                            </p>
                        </div>
                        <span class="flex items-center gap-x-2 -top-2">
                            <p>3:40 pm</p>
                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-2">
                    <img src="{{asset('assets/images/profile.jpg')}}" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                    <p class="text-base font-semibold font-inter">{{ $ticket->user->name }}</p>
                </div>
                <div class="-mt-2">
                    <div class="pl-14 -mt-3 flex gap-2">
                        <!-- Added flex, items-center, and gap classes -->
                        <div class="pt-2">
                            <p class="text-base font-normal font-inter inline-block">
                                I'm having trouble accessing my student portal. I keep getting an error message saying "Access Denied."
                            </p>
                        </div>
                        <span class="flex items-center gap-x-2 -top-2">
                            <p>3:40 pm</p>
                            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>