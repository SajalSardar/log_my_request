<x-app-layout>
    <livewire:team.update-team :team="$team" :agentUser="$agentUser" :categories="$categories" />
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
