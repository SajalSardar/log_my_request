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

    if ($year) {
        $output .= $y . ' y, ';
    }
    if ($month) {
        $output .= $mon . ' m, ';
    }
    if ($day) {
        $output .= $d . ' d, ';
    }
    if ($hour) {
        $output .= $h . ' h, ';
    }
    if ($minute) {
        $output .= $m . ' min and ';
    }
    if ($second) {
        $output .= $s . ' sec.';
    }
    $output = rtrim($output, ', ');
    return $output;
}
