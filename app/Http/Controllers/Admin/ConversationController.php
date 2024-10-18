<?php

namespace App\Http\Controllers\Admin;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ConversationController extends Controller
{
    /**
     * Method for replay the conversation
     * @param Request $request
     * @param Conversation $conversation
     * @return RedirectResponse
     */
    public function replay(Request $request, Conversation $conversation): RedirectResponse
    {
        $replay = Conversation::create([
            'ticket_id'             => $conversation->ticket_id,
            'requester_id'          => $conversation->requester_id,
            'parent_id'             => $conversation->id,
            'conversation_type'     => 'customer_type',
            'conversation'          => $request->conversation,
            'status'                => '1',
        ]);

        flash()->success('Replay has been added');
        return back();
    }
}
