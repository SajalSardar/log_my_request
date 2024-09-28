<?php

namespace App\Services\Ticket;

use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        // dd($request);
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

        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $checkUser->update(['phone' => $request->requester_phone, 'name' => $request->requester_name]);
        } else {
            $user = User::create([
                'name' => $request->requester_name,
                'email' => $request->requester_email,
                'phone' => $request->requester_phone,
                'password' => Hash::make('12345678'),
            ]);
        }

        $email_send = Mail::to($request->requester_email)->send(new TicketEmail($response));

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
