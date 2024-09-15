<x-app-layout>
    {{-- <x-base.table>

    </x-base.table>

    <x-base.form>

    </x-base.form> --}}
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
