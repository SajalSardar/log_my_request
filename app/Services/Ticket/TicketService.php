<?php

namespace App\Services\Ticket;

use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TicketService {
    /**
     * Define public property $user;
     * @var array|object
     */
    public $user = [];

    /**
     * Define public property $password;
     * @var string
     */
    public $password;

    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object {

        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->credentials = false;
            $checkUser->update(
                [
                    'phone'             => $request->requester_phone,
                    'name'              => $request->requester_name,
                    'requester_type_id' => $request->requester_type_id,
                    'requester_id'      => $request->requester_id,
                ]
            );
        } else {
            $this->password       = rand(10000000, 99999999);
            $request->credentials = true;
            $request->password    = $this->password;
            $this->user           = User::create([
                'name'              => $request?->requester_name,
                'email'             => $request?->requester_email,
                'phone'             => $request?->requester_phone,
                'password'          => Hash::make($this->password),
                'requester_type_id' => $request?->requester_type_id,
                'requester_id'      => $request?->requester_id,
            ]);
            $this->user->assignRole('agent');
        }

        $response = Ticket::create(
            [
                'user_id'          => $checkUser ? $checkUser->id : $this->user->id,
                'team_id'          => $request?->team_id,
                'category_id'      => $request?->category_id,
                'ticket_status_id' => $request?->ticket_status_id,
                'source_id'        => $request?->source_id,
                'title'            => $request?->request_title,
                'description'      => $request?->request_description,
                'priority'         => $request?->priority,
                'ticket_type'      => 'customer',
                'due_date'         => $request?->due_date,
                'created_by'       => Auth::id(),
            ]
        );

        $ticketStatus = TicketStatus::where('id', $request?->ticket_status_id)->first();

        $ticket_notes = TicketNote::create([
            'ticket_id'  => $response->getKey(),
            'note_type'  => 'initiated',
            'note'       => $request?->request_description,
            'new_status' => $ticketStatus?->name,
            'created_by' => Auth::user()->id,
        ]);

        $ticket_logs = TicketLog::create([
            'ticket_id'     => $response->getKey(),
            'ticket_status' => $ticketStatus?->name,
            'comment'       => json_encode($response),
            'status'        => 'create',
            'created_by'    => Auth::user()->id,
            'updated_by'    => Auth::user()->id,
        ]);

        if ($request->owner_id) {
            $response->owners()->attach($request->owner_id);
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
    public function update(Model $model, $request): array | object | bool {

        $response = Ticket::where('id', $model->getKey())->first();

        $response->team_id          = $request->team_id;
        $response->category_id      = $request->category_id;
        $response->ticket_status_id = $request->ticket_status_id;
        $response->source_id        = $request->source_id;
        $response->title            = $request->request_title;
        $response->description      = $request->request_description;
        $response->priority         = $request->priority;
        $response->ticket_type      = 'customer';
        $response->due_date         = $request->due_date;
        $response->updated_by       = Auth::user()->id;
        $response->save();

        $ticket_notes = TicketNote::query()->where('ticket_id', $model->getKey())->first();
        $ticket_notes->update([
            'note'       => $request?->request_description,
            'updated_by' => Auth::user()->id,
        ]);

        $ticketStatus = TicketStatus::where('id', $request?->ticket_status_id)->first();
        TicketLog::create([
            'ticket_id'     => $model->getKey(),
            'ticket_status' => $ticketStatus?->name,
            'comment'       => json_encode($response),
            'status'        => 'update',
            'created_by'    => Auth::user()->id,
            'updated_by'    => Auth::user()->id,
        ]);

        return $response;
    }
}
