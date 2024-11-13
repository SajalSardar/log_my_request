<?php

use Carbon\Carbon;

function ISOdate($date) {
    return $date ? date('M d, Y', strtotime($date)) : '';
}

function dayMonthYearHourMininteSecond($date, $endDate = null, $year = false, $month = false, $day = false, $hour = false, $minute = false, $second = false) {
    $startDate = Carbon::create($date);
    if ($endDate) {
        $endDate = $endDate;
    } else {
        $endDate = Carbon::now();
    }

    $y   = (int) $startDate->diffInYears($endDate);
    $mon = (int) $startDate
        ->copy()
        ->addYears($y)
        ->diffInMonths($endDate);
    $d = (int) $startDate
        ->copy()
        ->addYears($y)
        ->addMonths($mon)
        ->diffInDays($endDate);
    $h = (int) $startDate
        ->copy()
        ->addYears($y)
        ->addMonths($mon)
        ->addDays($d)
        ->diffInHours($endDate);
    $m = (int) $startDate
        ->copy()
        ->addYears($y)
        ->addMonths($mon)
        ->addDays($d)
        ->addHours($h)
        ->diffInMinutes($endDate);
    $s = (int) $startDate
        ->copy()
        ->addYears($y)
        ->addMonths($mon)
        ->addDays($d)
        ->addHours($h)
        ->addMinutes($m)
        ->diffInSeconds($endDate);

    $output = '';

    if ($year && $y != 0) {
        $output .= $y . ' year, ';
    }
    if ($month && $mon != 0) {
        $output .= $mon . ' month, ';
    }
    if ($day && $d != 0) {
        $output .= $d . ' day, ';
    }
    if ($hour && $h != 0) {
        $output .= $h . ' hour, ';
    }
    if ($minute && $m != 0) {
        $output .= $m . ' minute and ';
    }
    if ($second && $s != 0) {
        $output .= $s . ' second.';
    }
    $output = rtrim($output, ', ');
    return $output;
}

/**
 * Define method for get a string to camelCase
 * @param string $string
 * @return string
 */
function camelCase($string): string {
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
