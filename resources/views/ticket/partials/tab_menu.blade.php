<div class="flex w-full bg-[#F3F4F6] justify-between">
    <ul class="flex mb-0 list-none">
        <li class="-mb-px last:mr-0 px-5 text-center">
            <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-primary-400 text-white"
                onclick="changeAtiveTab(event,'tab-detail')">
                <i class="fas fa-space-shuttle text-base mr-1"></i> Details
            </a>
        </li>
        <li class="-mb-px last:mr-0 px-5 text-center">
            <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400"
                onclick="changeAtiveTab(event,'tab-conversation')">
                <i class="fas fa-cog text-base mr-1"></i> Conversations
            </a>
        </li>
        <li class="-mb-px last:mr-0 px-5 text-center">
            <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400"
                onclick="changeAtiveTab(event,'tab-history')">
                <i class="fas fa-briefcase text-base mr-1"></i> History
            </a>
        </li>

    </ul>
    @if (!Auth::user()->hasRole('requester') && ticketOpenProgressHoldPermission($ticket->ticket_status_id))
        <ul class="flex mb-0 list-none">
            <li class="-mb-px last:mr-0 px-2 text-center" x-on:click="$dispatch('open-offcanvas-requester')">
                <a
                    class="cursor-pointer text-sm font-semibold font-inter py-3 px-2 block bg-transparent text-black-400">
                    <i class="fas fa-space-shuttle text-base mr-1"></i> Add New Requester
                </a>
            </li>
            <li class="-mb-px last:mr-0 px-2 text-center" x-on:click="$dispatch('open-offcanvas-request')">
                <a
                    class="cursor-pointer text-sm font-semibold font-inter py-3 px-2 block bg-transparent text-black-400">
                    <i class="fas fa-cog text-base mr-1"></i> Edit Details
                </a>
            </li>
        </ul>
    @endif
</div>
