<?php

namespace App\Services\Ticket;

use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    /**
     * Define public property $user;
     * @var array|object
     */
    public $user = [];

    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        $response = Ticket::create(
            [
                'user_id' => Auth::user()->id,
                'requester_type_id' => $request->requester_type_id,
                'team_id' => $request->team_id,
                'category_id' => $request->category_id,
                'ticket_status_id' => $request->ticket_status_id,
                'source_id' => $request->source_id,
                'title' => $request->request_title,
                'description' => $request->request_description,
                'requester_id' => $request->requester_id,
                'priority' => $request->priority,
                'ticket_type' => 'customer',
                'due_date' => $request->due_date,
            ]
        );

        $ticket = Ticket::query()->where('id', $response->getKey())->with('ticket_status')->first();

        $ticket_notes = TicketNote::create([
            'ticket_id' => $response->getKey(),
            'note_type' => 'internal_note',
            'note' => $request?->request_description,
            'new_status' => $ticket?->ticket_status?->name,
            'created_by' => Auth::user()->id,
        ]);

        $ticket_logs = TicketLog::create([
            'ticket_id' => $response->getKey(),
            'ticket_status' => $ticket?->ticket_status?->name,
            'comment' => $request?->request_description,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->credentials = false;
            $checkUser->update(['phone' => $request->requester_phone, 'name' => $request->requester_name]);
        } else {
            $request->credentials = true;
            $this->user = User::create([
                'name' => $request->requester_name,
                'email' => $request->requester_email,
                'phone' => $request->requester_phone,
                'password' => Hash::make('12345678'),
            ]);
        }

        Mail::to($request->requester_email)->send(new TicketEmail($request));

        return $response;
    }

    /**
     * Define public method update to update the resourses
     * @param Model $model
     * @param $request
     * @return array|object|bool
     */
    public function update(Model $model, $request): array | object | bool
    {
        $model->update($request->all());
        return $model;
    }
}
