<x-app-layout>

    @role('super-admin')
    <h1 class="text-3xl font-inter font-bold mb-5">Welcome!</h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/5" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">Open Requests</p>
            </div>
        </div>
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/7" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">Open Requests</p>
            </div>
        </div>
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/6" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">Open Requests</p>
            </div>
        </div>
        <div class="row-span-2 border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/9" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">In Process Requests</p>
            </div>
        </div>
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/5" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">On Hold Requests</p>
            </div>
        </div>
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/7" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">Resolved Requests</p>
            </div>
        </div>
        <div class="border border-slate-100 rounded p-5">
            <img src="https://i.pravatar.cc/300/6" alt="profile" width="40" height="40" class="rounded-full">
            <div class="mt-3">
                <h4 class="text-xl font-inter font-semibold text-base-400">12,500</h4>
                <p class="text-sm font-inter font-normal text-base-400">Closed Requests</p>
            </div>
        </div>
         
    </div>

    @endrole








    @if (Helper::roleWiseAccess('attendee'))
    <p>attendee</p>
    @endif
    @if (Helper::roleWiseAccess('organizer'))
    <p>organizer</p>
    @endif
</x-app-layout>