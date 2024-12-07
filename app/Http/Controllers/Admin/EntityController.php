<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class EntityController extends Controller
{
    /**
     * Get all the resource entities
     * @param ?string $entity
     * @return View
     */
    public function index(?string $entity): View
    {
        $collections = match ($entity) {
            'requesters' => $this->requester(),
            'agents' => $this->agent(),
            'teams' => $this->team(),
            'categories' => $this->categories(),
            default => 'agents'
        };

        return view('entity.index', compact('collections'));
    }

    /**
     * Get all requester resources
     * @return array|object
     */
    public function requester(): array|object
    {
        $response = User::query()
            ->withCount('requester_tickets')
            ->orderBy('requester_tickets_count', 'desc')
            ->get();
        return $response->map(
            fn($query, $entity) =>
            (object) [
                'id' => $query->id,
                'name' => $query->name,
                'total' => $query->requester_tickets_count ?? 0,
                'action' => (object)
                [
                    'edit' => route('admin.user.edit', ['user' => $query->id]),
                    'delete' => route('admin.user.delete', ['user' => $query->id])
                ]
            ]
        )->toBase();
    }

    /**
     * Get all agent resources
     * @return array|object
     */
    public function agent(): array|object
    {
        $response = User::query()
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->get();

        return $response->map(fn($query) =>
        (object) [
            'id' => $query->id,
            'name' => $query->name,
            'total' => $query->tickets_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.ticket.edit', ['ticket' => $query->id]),
                'delete' => route('admin.ticket.delete', ['ticket' => $query->id])
            ]
        ])->toBase();
    }

    /**
     * Get all team resources
     * @return array|object
     */
    public function team(): array|object
    {
        $response = Team::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->get();
        return $response->map(fn($query) =>
        (object) [
            'id' => $query->id,
            'name' => $query->name,
            'total' => $query->tickets_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.team.edit', ['team' => $query->id]),
                'delete' => route('admin.team.destroy', ['team' => $query->id])
            ]
        ])->toBase();
    }

    /**
     * Get all categories resources
     * @return array|object
     */
    public function categories(): array|object
    {
        $response = Category::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->get();
        return $response->map(fn($query) =>
        (object) [
            'id' => $query->id,
            'name' => $query->name,
            'total' => $query->ticket_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.category.edit', ['category' => $query->id]),
                'delete' => route('admin.category.destroy', ['category' => $query->id])
            ]
        ])->toBase();
    }
}
