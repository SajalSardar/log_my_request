<?php

namespace App\Services\Ticket;

use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketOwnership;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $this->user->assignRole('requester');
        }

        $response = Ticket::create(
            [
                'user_id'          => $checkUser ? $checkUser->id : $this->user->id,
                'department_id'    => $request?->department_id,
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
    public function update(Model $model, $request) {

        $ticket    = Ticket::with('owners')->where('id', $model->getKey())->first();
        $requester = User::where('email', $request->requester_email)->first();

        DB::beginTransaction();
        try {
            if (!empty($requester)) {
                $requester->update(
                    [
                        'phone'             => $request->requester_phone,
                        'name'              => $request->requester_name,
                        'requester_type_id' => $request->requester_type_id,
                        'requester_id'      => $request->requester_id,
                    ]
                );
            }

            $ticket_status = TicketStatus::query()->where('id', $ticket->ticket_status_id)->first();

            if ($request->owner_id && ($ticket->owners->isEmpty() || $ticket->owners->last()->id != $request->owner_id)) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'owner_change',
                        'note'       => 'Edit',
                        'created_by' => Auth::id(),
                    ]
                );

                $last_owner = TicketOwnership::where('ticket_id', $ticket->id)->where('duration', null)->orderBy('id', 'desc')->first();
                if ($last_owner && $request->owner_id) {
                    $now                 = Carbon::now();
                    $duration_in_seconds = $last_owner->created_at->diffInSeconds($now);
                    $last_owner->update([
                        'duration' => $duration_in_seconds,
                    ]);
                }

                $ticket_agents = $ticket->owners()->attach($request->owner_id);
            }
            if ($ticket->team_id != $request->team_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'team_change',
                        'note'       => 'Edit',
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->category_id != $request->category_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'category_change',
                        'note'       => 'Edit',
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->priority != $request->priority) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'priority_change',
                        'note'       => 'Edit',
                        'created_by' => Auth::id(),
                    ]
                );
            }

            $old_due_date = $ticket->due_date ? $ticket->due_date->format('Y-m-d') : '';
            if (empty($old_due_date) || $old_due_date != $request->due_date) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'due_date_change',
                        'note'       => 'Edit',
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->ticket_status_id != $request->ticket_status_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'status_change',
                        'note'       => 'Edit',
                        'old_status' => $ticket->ticket_status->name,
                        'new_status' => $ticket_status->name,
                        'created_by' => Auth::id(),
                    ]
                );
            }

            $ticket->update(
                [
                    'department_id'    => $request?->department_id,
                    'source_id'        => $request->source_id,
                    'title'            => $request->request_title,
                    'description'      => $request->request_description,
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'updated_by'       => Auth::id(),
                ]
            );
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket_status->name,
                    'status'        => 'updated',
                    'comment'       => json_encode($ticket),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket_status->name,
                    'status'        => 'update_fail',
                    'comment'       => json_encode($e->getMessage()),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );
        }

        return $ticket;
    }
}
