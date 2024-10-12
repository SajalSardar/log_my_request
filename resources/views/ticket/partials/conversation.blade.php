<div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-5">
    <div class="col-span-2">
        <div class="mt-3 p-4 border border-slate-200">

            <form>
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <input type="hidden" name="requester_id" value="{{ $ticket->user_id }}">
                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <textarea cols="30" id="conversation" rows="10" name='conversation'
                        class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                        placeholder="Add Comment here.."></textarea>
                    <x-input-error :messages="$errors->get('conversation')" class="mt-2" />
                </div>
                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.input-file wire:model="form.request_attachment" accept=".pdf,.docs,.ppt" />
                        <x-input-error :messages="$errors->get('form.request_attachment')" class="mt-2" />
                    </div>
                </div>
                <div class="text-right">
                    <x-buttons.primary class="mt-2 ml-auto">
                        Add conversation
                    </x-buttons.primary>
                </div>
            </form>
        </div>
    </div>

    <div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium inventore assumenda maiores aspernatur,
            tenetur nemo quasi magnam quo magni earum labore fuga cumque, nobis numquam animi quas veritatis a
            voluptatibus!</p>
    </div>

</div>
