<?php

use App\Models\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class Helper {
    /**
     * Define public static method ISOdate() to see the date in international format
     * @param $date
     * @return string
     */
    public static function ISOdate($date) {
        return $date ? date('M d, Y', strtotime($date)) : '';
    }

    /**
     * Define public function for active and inactive status
     * @param string $status
     * @return string
     */
    public static function status(?string $status): string {
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
    public static function badge(?string $string): string {
        $escapedString = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        return '<span class="inline-flex items-center bg-green-100 text-gray-800 text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">
                <span class="p-1">
                ' . $escapedString . '
           </span></span>';
    }

    /**
     * Define public function for show date in human readable form
     * @param string $date
     * @return string
     */
    public static function humanReadableDate(?string $date): string {
        return Carbon::parse($date)->diffForHumans();
    }

    //get login user roles
    public static function getLoggedInUserRoles() {
        $user = auth()->user()->load('roles');
        return $user->roles;
    }
    public static function getLoggedInUserRoleSession() {
        $loginRole = Session::has('login_role') ? Session::get('login_role') : '';
        return strtolower($loginRole);
    }

    public static function roleWiseAccess($role) {
        if (auth()->user()->hasRole(strtolower($role)) && Helper::getLoggedInUserRoleSession() === $role) {
            return true;
        }
        return false;
    }

    //get all menu and sub menu
    public static function getAllMenus() {
        $loginRole = Helper::getLoggedInUserRoleSession();
        $menus     = Menu::with(['submneus' => function ($q) use ($loginRole) {
            $q->orderBy('order', 'asc')
                ->where('status', 'active')
                ->whereJsonContains('roles', $loginRole);
        }])
            ->whereJsonContains('roles', $loginRole)
            ->where('parent_id', null)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        return $menus;
    }

}
