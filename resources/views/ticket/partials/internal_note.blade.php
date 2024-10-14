<!-- Notes Part Start !-->
<div class="flex justify-between mt-8">
    <button class="px-3 py-1 text-base-400 bg-[#FFF4EC] rounded-sm text-base font-semibold font-inter">
        Internal Notes
    </button>
</div>
<div class="mt-3 p-4 border border-slate-200">
    <form action="{{ route('admin.ticket.interNoteStore',['ticket' => $ticket?->id]) }}" method="POST">
        @csrf
        <div>
            <textarea cols="30" id="internal_note" rows="10" name='internal_note'
                class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded" placeholder="Add Inter note here.."></textarea>
            <x-input-error :messages="$errors->get('internal_note')" class="mt-2" />
        </div>
        <div class="text-right">
            <x-buttons.primary class="mt-2 ml-auto">
                Add Note
            </x-buttons.primary>
        </div>
    </form>
</div>

<div class="mt-3 p-4 border border-slate-200">
    @if (is_object($ticket->ticket_notes) && $ticket->ticket_notes->count() > 0)
    @foreach ($ticket->ticket_notes as $note)
    <div class="mb-5">
        <div class="flex items-center gap-2">
            <img src="{{asset('assets/images/profile.jpg')}}" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
            <p class="text-base font-semibold font-inter">{{ $ticket->user->name }}</p>
        </div>
        <div class="-mt-2">
            <div class="flex gap-1 pl-14">
                <p class="text-base font-normal font-inter inline-block">Added a private note one week ago</p>
                <span>({{ date('l, d M, Y H:m:a', strtotime($note->created_at))}})</span>
            </div>
            <div class="pl-14 -mt-3 flex items-end gap-2"> <!-- Added flex, items-center, and gap classes -->
                <div>
                    <p class="text-base font-normal font-inter inline-block">{!! $note?->note ?? '--' !!}</p>
                </div>
                <span class="inline-block">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.26781 18.8447C4.49269 20.515 5.87613 21.8235 7.55966 21.9009C8.97627 21.966 10.4153 22 12 22C13.5847 22 15.0237 21.966 16.4403 21.9009C18.1239 21.8235 19.5073 20.515 19.7322 18.8447C19.879 17.7547 20 16.6376 20 15.5C20 14.3624 19.879 13.2453 19.7322 12.1553C19.5073 10.485 18.1239 9.17649 16.4403 9.09909C15.0237 9.03397 13.5847 9 12 9C10.4153 9 8.97627 9.03397 7.55966 9.09909C5.87613 9.17649 4.49269 10.485 4.26781 12.1553C4.12104 13.2453 4 14.3624 4 15.5C4 16.6376 4.12104 17.7547 4.26781 18.8447Z" stroke="#666666" stroke-width="1.5" />
                        <path d="M7.5 9V6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5V9" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.9961 15.5H12.0051" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        </div>

    </div>
    @endforeach

    @endif

</div>

<div class="flex justify-end p-3">
    <button>
        <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z"
                stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <button>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M3.5 10C3.5 6.70017 3.5 5.05025 4.52513 4.02513C5.55025 3 7.20017 3 10.5 3H13.5C16.7998 3 18.4497 3 19.4749 4.02513C20.5 5.05025 20.5 6.70017 20.5 10V15C20.5 18.2998 20.5 19.9497 19.4749 20.9749C18.4497 22 16.7998 22 13.5 22H10.5C7.20017 22 5.55025 22 4.52513 20.9749C3.5 19.9497 3.5 18.2998 3.5 15V10Z"
                stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 15H12M8 10H16" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
        </svg>
    </button>
</div>

<!-- Notes Part End !-->