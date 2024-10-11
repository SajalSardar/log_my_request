<?php

use Carbon\Carbon;

function ISOdate($date) {
    return $date ? date('M d, Y', strtotime($date)) : '';
}

function dayMonthYearHourMininteSecond($date, $year = false, $month = false, $day = false, $hour = false, $minute = false, $second = false) {
    $startDate = Carbon::create($date);
    $endDate   = Carbon::now();

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
        $output .= $y . ' years, ';
    }
    if ($month) {
        $output .= $mon . ' months, ';
    }
    if ($day) {
        $output .= $d . ' days, ';
    }
    if ($hour) {
        $output .= $h . ' hours, ';
    }
    if ($minute) {
        $output .= $m . ' minutes and ';
    }
    if ($second) {
        $output .= $s . ' seconds.';
    }
    $output = rtrim($output, ', ');
    return $output;
}