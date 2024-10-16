<form action="{{ route('admin.ticket.logUpdate', ['ticket' => $ticket->id]) }}" method="POST">
    @csrf
    <div class="flex flex-row">
        <div class="md:basis-full sm:basis-full">
            <div class="border border-slate-300 p-4 rounded">

                <div class="grid">
                    <div>
                        <x-forms.label for="due_date">
                            {{ __('Due Date') }}
                        </x-forms.label>
                        <x-forms.text-input type="date" name="due_date"
                            value="{{ $ticket?->due_date ? date('Y-m-d', strtotime($ticket->due_date)) : '' }}" />
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-2 sm:gap-1 md:gap-3">
                    <div class="mt-3">
                        <x-forms.label for="category_id" required="yes">
                            {{ __('Category') }}
                        </x-forms.label>

                        <x-forms.select-input name="category_id">
                            <option value>Category</option>
                            @foreach ($categories as $each)
                                <option @selected(old('category_id', $ticket?->category_id) == $each?->id) value="{{ $each?->id }}">
                                    {{ $each?->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <div class="mt-3">
                        <x-forms.label for="ticket_status_id" required="yes">
                            {{ __('Status') }}
                        </x-forms.label>

                        <x-forms.select-input name="ticket_status_id">
                            <option value="">Ticket status
                            </option>
                            @foreach ($ticket_status as $status)
                                <option @selected(old('ticket_status_id', $ticket?->ticket_status_id) == $status?->id) value="{{ $status->id }}">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('ticket_status_id')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-2 sm:gap-1 md:gap-3">
                    <div class="mt-3">
                        <x-forms.label for="team_id" required="yes">
                            {{ __('Assign Team') }}
                        </x-forms.label>

                        <x-forms.select-input name="team_id" id="team">
                            <option value="">Select a Team
                            </option>
                            @foreach ($teams as $each)
                                <option value="{{ $each->id }}" @selected(old('team_id', $ticket?->team_id) == $each?->id)>
                                    {{ $each->name }}</option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                    </div>
                    <div class="mt-3">
                        <x-forms.label for="owner_id">
                            {{ __('Assign Agent') }}
                        </x-forms.label>

                        <x-forms.select-input name="owner_id">
                            <option value="">Assign Agent
                            </option>
                            @foreach ($agents as $each)
                                @foreach ($each->agents as $item)
                                    <option
                                        {{ in_array($item->id, $ticket?->owners?->pluck('id')->toArray()) ? 'selected' : '' }}
                                        value="{{ $item?->id }}">
                                        {{ $item?->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                    </div>
                </div>
                <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 mt-2">
                    <div class="p-2 w-full">
                        <x-forms.label for="priority" required="yes">
                            {{ __('Requester Priority') }}
                        </x-forms.label>
                        <div class="mt-2">
                            <x-forms.radio-input name="priority" :checked="$ticket->priority === 'low'" value="low" />
                            <span class="ml-2">Low</span>

                            <x-forms.radio-input name="priority" class="ml-2" value="medium" :checked="$ticket->priority === 'medium'" />
                            <span class="ml-2">Medium</span>

                            <x-forms.radio-input name="priority" class="ml-2" value="high" :checked="$ticket->priority === 'high'" />
                            <span class="ml-2">High</span>
                        </div>
                        <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                    </div>
                </div>

                <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 mt-3">
                    <x-forms.label for="comment" required="yes">
                        {{ __('Changes Note') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <textarea cols="30" id="editor" rows="10" name='comment'
                            class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                            placeholder="Add Comment here.."></textarea>
                        <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-3">
                    <x-buttons.primary>
                        Update
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</form>

