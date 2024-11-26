<?php

use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function ISOdate($date)
{
    return $date ? date('M d, Y', strtotime($date)) : '';
}

// function dayMonthYearHourMininteSecond($date, $endDate = null, $year = false, $month = false, $day = false, $hour = false, $minute = false, $second = false) {
//     $startDate = Carbon::create($date);
//     if ($endDate) {
//         $endDate = $endDate;
//     } else {
//         $endDate = Carbon::now();
//     }

//     $y   = (int) $startDate->diffInYears($endDate);
//     $mon = (int) $startDate
//         ->copy()
//         ->addYears($y)
//         ->diffInMonths($endDate);
//     $d = (int) $startDate
//         ->copy()
//         ->addYears($y)
//         ->addMonths($mon)
//         ->diffInDays($endDate);
//     $h = (int) $startDate
//         ->copy()
//         ->addYears($y)
//         ->addMonths($mon)
//         ->addDays($d)
//         ->diffInHours($endDate);
//     $m = (int) $startDate
//         ->copy()
//         ->addYears($y)
//         ->addMonths($mon)
//         ->addDays($d)
//         ->addHours($h)
//         ->diffInMinutes($endDate);
//     $s = (int) $startDate
//         ->copy()
//         ->addYears($y)
//         ->addMonths($mon)
//         ->addDays($d)
//         ->addHours($h)
//         ->addMinutes($m)
//         ->diffInSeconds($endDate);

//     $output = '';

//     if ($year && $y != 0) {
//         $output .= $y . ' year, ';
//     }
//     if ($month && $mon != 0) {
//         $output .= $mon . ' month, ';
//     }
//     if ($day && $d != 0) {
//         $output .= $d . ' day, ';
//     }
//     if ($hour && $h != 0) {
//         $output .= $h . ' hour, ';
//     }
//     if ($minute && $m != 0) {
//         $output .= $m . ' minute and ';
//     }
//     if ($second && $s != 0) {
//         $output .= $s . ' second.';
//     }
//     $output = rtrim($output, ', ');
//     return $output;
// }


function dayMonthYearHourMininteSecond($date, $endDate = null)
{
    $startDate = Carbon::create($date);
    $endDate = $endDate ? Carbon::create($endDate) : Carbon::now();

    $y   = (int) $startDate->diffInYears($endDate);
    $mon = (int) $startDate->copy()->addYears($y)->diffInMonths($endDate);
    $d   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->diffInDays($endDate);
    $h   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->diffInHours($endDate);
    $m   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->addHours($h)->diffInMinutes($endDate);
    $s   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->addHours($h)->addMinutes($m)->diffInSeconds($endDate);

    $output = [];

    if ($y > 0) {
        $output[] = $y . ' ' . ($y > 1 ? 'years' : 'year');
    }
    if ($mon > 0) {
        $output[] = $mon . ' ' . ($mon > 1 ? 'months' : 'month');
    }
    if ($d > 0) {
        $output[] = $d . ' ' . ($d > 1 ? 'days' : 'day');
    }
    if ($h > 0) {
        $output[] = $h . ' ' . ($h > 1 ? 'hours' : 'hour');
    }
    if ($m > 0) {
        $output[] = $m . ' ' . ($m > 1 ? 'mins' : 'min');
    }
    if ($s > 0) {
        $output[] = $s . ' ' . ($s > 1 ? 'seconds' : 'second');
    }

    // Customize the level of detail:
    if (count($output) > 3) {
        $output = array_slice($output, 0, 3); // Limit to 3 components for simplicity.
    }

    return implode(', ', $output);
}


/**
 * Define method for get a string to camelCase
 * @param string $string
 * @return string
 */
function camelCase($string): string
{
    $string = str_replace(
        ' ',
        ' ',
        ucwords(str_replace(
            ['-', '_'],
            ' ',
            $string
        ))
    );

    return $string;
}

function getTicketStatusById($id)
{
    $ticketStatus = TicketStatus::where('id', $id)->first();
    if ($ticketStatus) {

        return $ticketStatus;
    }
    return false;
}

function ticketOpenProgressHoldPermission($ticket_status_id)
{
    $ticketStatus = TicketStatus::where('id', $ticket_status_id)->first();
    return $ticketStatus->slug == 'open' || $ticketStatus->slug == 'in-progress' || $ticketStatus->slug == 'on-hold' ? true : false;
}

function getTicketNotsNotify()
{

    $query = TicketNote::query()->where('view_notification', 0)->whereNotIn('note_type', ['internal_note']);
    if (Auth::user()->hasRole(['requester', 'Requester'])) {
        $ticketId = Ticket::where('user_id', Auth::id())->pluck('id');
        $query->whereIn('ticket_id', $ticketId);
    }
    if (Auth::user()->hasRole(['agent', 'Agent'])) {
        $userTeamIds = User::find(Auth::id())->teams->pluck('id');
        $ticketId    = Ticket::whereIn('team_id', $userTeamIds)->pluck('id');
        $query->whereIn('ticket_id', $userTeamIds);
    }
    $ticketNotifyNotes = $query->orderBy('id', 'desc')->get();

    return $ticketNotifyNotes;
}
