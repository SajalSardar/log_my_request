<?php

namespace App\Decorators;

use App\Models\Team;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardDecorator
{
    public static function chart()
    {
        $resource = DB::table('tickets')->select('priority', DB::raw('count(*) as total'))->groupBy('priority')->get();
        $ttlCount = $resource->map(fn($i) => $i->total)->sum();
        return $resource->map(function ($item) use ($ttlCount) {
            $color = match (true) {
                'low'       => '#10B981',
                'medium'    => '#3B82F6',
                'high'      => '#EF4444',
                default     => 'orange'
            };

            return (object) [
                'value'     => (int) number_format(round($item->total / $ttlCount * 100), 2),
                'color'     => $color,
                'title'     => ucfirst($item->priority),
            ];
        })->toBase();
    }

    public static function state()
    {
        return DB::table('ticket_statuses as status')
            ->leftJoin('tickets as ticket', 'status.id', '=', 'ticket.ticket_status_id')
            ->select(DB::raw('count(ticket.id) as count, status.name'))
            ->groupBy('status.name')
            ->get();
    }

    public static function traffic()
    {
        $resource = User::query()
            ->withCount('requester_tickets')
            ->orderBy('requester_tickets_count', 'desc')
            ->limit(5)
            ->get();
        return $resource->map(fn($user) => [
            'name' => $user->name,
            'total' => $user->requester_tickets_count,
        ])->toBase();
    }

    public static function agents()
    {
        $resource = User::query()
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->limit(5)
            ->get();
        return $resource->map(fn($user) => [
            'name' => $user->name,
            'total' => $user->tickets,
        ])->toBase();
    }

    public static function categories()
    {
        $resource = Category::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get();

        return $resource->map(fn($user) => [
            'name' => $user->name,
            'total' => $user->ticket_count,
        ])->toBase();
    }

    public static function teams()
    {
        $resource = Team::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get();

        return $resource->map(fn($user) => [
            'name' => $user->name,
            'total' => $user->ticket_count,
        ])->toBase();
    }
}

 


 
 

 

// $this->responses['teams'] = Team::query()
//     ->withCount('ticket')
//     ->orderBy('ticket_count', 'desc')
//     ->limit(5)
//     ->get()
//     ->map(function ($user) {
//         return [
//             'name' => $user->name,
//             'total' => $user->ticket_count,
//         ];
//     });
