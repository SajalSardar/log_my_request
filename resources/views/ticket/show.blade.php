<x-app-layout>
    <header class="mb-6">
        <span class="text-base font-bold font-inter">Request ID & Title: #{{ $ticket?->id }} ,
            {{ $ticket?->title }}</span>
    </header>


    <div class="flex flex-wrap" id="tabs-id">
        <div class="w-full">
            @include('ticket/partials/tab_menu')

            <div class="relative flex flex-col min-w-0 break-words bg-white w-full my-6">
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <div class="block" id="tab-detail">
                            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-5">
                                <div class="col-span-2">

                                    @include('ticket/partials/details')
                                    @if (!Auth::user()->hasRole('requester'))
                                        @include('ticket/partials/internal_note')
                                    @endif

                                </div>
                                @if (!Auth::user()->hasRole('requester'))
                                    <div>
                                        <!-- Edit Part Start !-->
                                        <div class="mt-3">
                                            @include('ticket/partials/sidebar_form')
                                        </div>
                                        <!-- Edit Part End !-->

                                        <div class="mt-4">
                                            <p class="text-base font-bold font-inter">
                                                {{ Str::ucfirst($ticket?->ticket_status?->name) }}
                                                Requests <a
                                                    href="{{ route('admin.ticket.status.wise.list', ['ticket_status' => $ticket?->ticket_status->slug]) }}"
                                                    class="float-right underline text-sm text-green-500">View All</a>
                                            </p>
                                            @include('ticket/partials/request_list')
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="hidden" id="tab-conversation">
                            @include('ticket/partials/conversation')
                        </div>
                        <div class="hidden" id="tab-history">
                            @include('ticket/partials/history')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!Auth::user()->hasRole('requester'))
        @include('ticket/partials/requester_offcanvas')
        @include('ticket/partials/request_offcanvas')
    @endif

    @section('style')
        <style>
            .ck-editor__editable_inline {
                min-height: 200px;
                /* Adjust the height to your preference */
            }

            .reply-box {
                transition: opacity 0.3s ease, max-height 0.3s ease;
            }

            .show {
                opacity: 1;
                max-height: 200px;
                /* Adjust as needed for your textarea */
            }
        </style>
    @endsection

    @section('script')
        <script>
            let team = document.querySelector('#team');
            team.addEventListener('change', function(e) {
                let team_id = e.target.value;
                let ticket_id = '@json($ticket->id)';
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.ticket.show', ['ticket' => '__TICKET_ID__']) }}".replace(
                        '__TICKET_ID__', ticket_id),
                    dataType: 'json',
                    data: {
                        team_id: team_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let ownerSelect = $('select[name="owner_id"]');
                        ownerSelect.find('option:not(:first)').remove();
                        response.forEach(element => {
                            element.agents.forEach(e => {
                                ownerSelect.append(new Option(e.name, e.id));
                            })
                        });
                    }
                });
            });
        </script>


        <script type="text/javascript">
            function changeAtiveTab(event, tabID) {
                let element = event.target;
                while (element.nodeName !== "A") {
                    element = element.parentNode;
                }
                ulElement = element.parentNode.parentNode;
                aElements = ulElement.querySelectorAll("li > a");
                tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");

                for (let i = 0; i < aElements.length; i++) {
                    aElements[i].classList.remove("text-white");
                    aElements[i].classList.remove("bg-primary-400");
                    aElements[i].classList.add("text-black-400");
                    aElements[i].classList.add("bg-transparent");
                    tabContents[i].classList.add("hidden");
                    tabContents[i].classList.remove("block");
                }

                element.classList.remove("text-black-400");
                element.classList.remove("bg-transparent");
                element.classList.add("text-white");
                element.classList.add("bg-primary-400");

                document.getElementById(tabID).classList.remove("hidden");
                document.getElementById(tabID).classList.add("block");
            }
        </script>
        <script>
            activeCkEditor('editor');
            activeCkEditor('request_description');
            activeCkEditor('internal_note');
            activeCkEditor('conversation');

            $(".select2").select2({
                allowClear: true,
            });

            $(document).on('change', '#userOnChabge', function() {
                let user_id = $(this).val();
                let url = "{{ route('admin.get.user.by.id') }}";
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    data: {
                        user_id: user_id,
                    },
                    success: function(response) {
                        if (response) {
                            let requester_name = $('#requester_name'),
                                requester_email = $('#requester_email'),
                                requester_phone = $('#requester_phone'),
                                requester_type_id = $('#requester_type_id'),
                                requester_id = $('#requester_id');

                            requester_name.val(response.name);
                            requester_email.val(response.email);
                            requester_phone.val(response.phone);
                            requester_id.val(response.requester_id);
                            requester_type_id.val(response.requester_type_id).trigger('change');
                        } else {
                            alert('User data could not be retrieved. Please try again.');
                        }
                    }
                });
            });
        </script>
        <script>
            function toggleReplay(id) {
                const textarea = document.querySelector(`.replay-${id}`);
                if (textarea) {
                    const isVisible = textarea.style.opacity === '1';
                    if (isVisible) {
                        textarea.style.opacity = '0';
                        textarea.style.maxHeight = '0';
                    } else {
                        textarea.style.opacity = '1';
                        textarea.style.maxHeight = '150px';
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
