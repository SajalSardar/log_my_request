<?php

namespace App\Services\Ticket;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TicketService
{
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
