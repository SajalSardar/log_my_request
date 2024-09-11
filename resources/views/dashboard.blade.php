<x-app-layout>
    {{-- <x-base.table>

    </x-base.table>

    <x-base.form>

    </x-base.form> --}}
    @role('super-admin')
        <p>Super Admin</p>
    @endrole

    @php
        $loginRole = Session::has('login_role') ? Session::get('login_role') : '';
    @endphp
    @if (auth()->user()->hasRole('attendee') && $loginRole === 'attendee')
        <p>attendee</p>
    @endif
    @if (auth()->user()->hasRole('organizer') && $loginRole === 'organizer')
        <p>organizer</p>
    @endif
</x-app-layout>
