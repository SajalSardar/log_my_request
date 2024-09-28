<x-app-layout>

    @role('super-admin')
        <p>Super Admin</p>
    @endrole

    @if (Helper::roleWiseAccess('attendee'))
        <p>attendee</p>
    @endif
    @if (Helper::roleWiseAccess('organizer'))
        <p>organizer</p>
    @endif
</x-app-layout>
