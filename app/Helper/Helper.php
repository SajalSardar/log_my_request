<?php

use Illuminate\Support\Carbon;

class Helper
{
    /**
     * Define public static method ISOdate() to see the date in international format
     * @param $date
     * @return string
     */
    public static function ISOdate($date)
    {
        return date_format($date, 'd M, Y');
    }

    /**
     * Define public function for active and inactive status
     * @param string $status
     * @return string
     */
    public static function status(?string $status): string
    {
        if ($status == '1') {
            return ' <span class="inline-flex items-center bg-green-100 text-white text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">
                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                        Active
                    </span>';
        } else {
            return '<span class="inline-flex items-center bg-red-100 text-white text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-600 dark:text-red-300">
                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                        Inactive
                    </span>';
        }
    }

    /**
     * Define public static function badge(?string $string)
     * @param ?string $string
     * @return string
     */
    public static function badge(?string $string): string
    {
        $escapedString = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        return '<span class="inline-flex items-center bg-green-100 text-white text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">
                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                ' . $escapedString . '
           </span>';
    }


    /**
     * Define public function for show date in human readable form
     * @param string $date
     * @return string
     */
    public static function humanReadableDate(?string $date): string
    {
        return  Carbon::parse($date)->diffForHumans();
    }
}
