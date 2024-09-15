<?php

use App\Models\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Helper {
    /**
     * Define public static method ISOdate() to see the date in international format
     * @param $date
     * @return string
     */
    public static function ISOdate($date) {
        return $date ? date_format($date, 'd M, Y') : '';
    }

    /**
     * Define public function for active and inactive status
     * @param string $status
     * @return string
     */
    public static function status(?string $status): string {
        if ($status === '1') {
            return ' <span class="inline-flex items-center bg-green-100 text-white text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">
                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                        Available
                    </span>';
        } else {
            return '<span class="inline-flex items-center bg-red-100 text-white text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-600 dark:text-red-300">
                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                        Unavailable
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
        return '<span class="inline-flex items-center bg-green-100 text-white text-xs font-normal px-2.5 py-0.5 rounded-full dark:bg-green-600 dark:text-green-300">
                <span class="p-1 bg-gray-500 rounded-md">
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

    //get all menu and sub menu
    public static function getAllMenus() {
        $menu = Cache::remember('menu_list', 60 * 60, function () {
            return Menu::with(['submneus' => function ($q) {
                $q->orderBy('order', 'asc');
            }])
                ->where('parent_id', null)
                ->where('status', 'active')
                ->orderBy('order', 'asc')
                ->get();
        });
        return $menu;
    }

    //get login user roles
    public static function getLoggedInUserRoles() {
        $user = auth()->user()->load('roles');
        return $user->roles;
    }
    public static function getLoggedInUserRoleSession() {
        $loginRole = Session::has('login_role') ? Session::get('login_role') : '';
        return $loginRole;
    }

    public static function roleWiseAccess($role) {
        if (auth()->user()->hasRole($role) && Helper::getLoggedInUserRoleSession() === $role) {
            return true;
        }
        return false;
    }

    public static function roleWiseMenuPermission($menu_id) {
        $roles      = Menu::where('id', $menu_id)->select('roles')->first();
        $roleDecode = json_decode($roles->roles, true);
        $loginRole  = Helper::getLoggedInUserRoleSession();
        if (in_array($loginRole, $roleDecode)) {
            return true;
        }
        return false;
    }
}
