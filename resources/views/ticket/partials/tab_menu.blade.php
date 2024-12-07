<div>
    <ul class="flex justify-between flex-wrap items-center bg-[#F3F4F6]">
        <div class="flex">
            <li id="homeTab" class="tab !text-primary-400 text-detail-heading py-2.5 px-5 border-b-2 border-primary-400 cursor-pointer">
                Detail
            </li>
            <li id="settingTab" class="tab text-detail-heading py-2.5 px-5 border-b-2 border-transparent cursor-pointer">
                Conversations
            </li>
            <li id="profileTab" class="tab text-detail-heading py-2.5 px-5 border-b-2 border-transparent cursor-pointer">
                History
            </li>
        </div>

        <div class="flex">
            @if (!Auth::user()->hasRole(['requester', 'Requester']) && ticketOpenProgressHoldPermission($ticket->ticket_status_id))
            <li class="-mb-px last:mr-0 px-2 text-center" x-on:click="$dispatch('open-offcanvas-requester')">
                <a
                    class="cursor-pointer text-detail-heading py-2.5 px-2 block bg-transparent">
                    <i class="fas fa-space-shuttle text-base mr-1"></i> Add New Requester
                </a>
            </li>
            <li class="-mb-px last:mr-0 px-2 text-center" x-on:click="$dispatch('open-offcanvas-request')">
                <a
                    class="cursor-pointer text-detail-heading py-2.5 px-2 block bg-transparent">
                    <i class="fas fa-cog text-base mr-1"></i> Edit Details
                </a>
            </li>
            @endif
        </div>
    </ul>

    <div id="homeContent" class="tab-content">
        <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-3 md:gap-32 lg:gap-32">
            <div class="col-span-2">
                @include('ticket/partials/details')
                @if (!Auth::user()->hasRole(['requester', 'Requester']))
                @include('ticket/partials/internal_note')
                @endif
            </div>
            @if (!Auth::user()->hasRole(['requester', 'Requester']))
            <div>
                <div class="mt-3">
                    @include('ticket/partials/sidebar_form')
                </div>
            </div>
            @endif
        </div>
    </div>
    <div id="settingContent" class="tab-content hidden ">
        @include('ticket/partials/conversation')
    </div>
    <div id="profileContent" class="tab-content hidden ">
        @include('ticket/partials/history')
    </div>
</div>