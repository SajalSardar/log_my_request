<x-app-layout>
    <div class="p-5 rounded-lg shadow-lg">
        <header class="py-5 px-2 grid md:grid-cols-2 sm:grid-cols-1 md:gap-1 sm:gap-1">
            <div class="infos">
                <h3 class="font-bold text-xl">Create Team</h3>
                <p>Please fill the input field where sign <span class="text-red-500">(*) </span> have.</p>
            </div>

            <div class="flex md:flex-row-reverse sm:flex-row">
                <div>
                    <x-actions.href href="{{ route('admin.team.index') }}">
                        {{ __('Team Create') }}
                    </x-actions.href>
                </div>
            </div>
        </header>
        <hr>
        <livewire:team.create-team :categories="$categories" :agentUser="$agentUser" />

    </div>
    @section('style')
        <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    @endsection
    @section('script')
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endsection
</x-app-layout>
