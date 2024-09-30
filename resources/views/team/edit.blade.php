<x-app-layout>
    <livewire:team.update-team :team="$team" :agentUser="$agentUser" :categories="$categories" />
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initSelect2('categories_input');
                initSelect2('agent_id');

            });
        </script>
    @endsection
</x-app-layout>
