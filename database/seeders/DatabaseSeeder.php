<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::factory()->create([
            'name'              => 'Super Admin',
            'email'             => "superadmin@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $attendeeuser = User::factory()->create([
            'name'              => 'Attendee',
            'email'             => "attendee@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $organizeruser = User::factory()->create([
            'name'              => 'Organizer',
            'email'             => "organizer@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);
        $organizerAttendeeUser = User::factory()->create([
            'name'              => 'organizer Attendee',
            'email'             => "organizerattendee@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $role      = Role::create(['name' => 'super-admin']);
        $attendee  = Role::create(['name' => 'attendee']);
        $organizer = Role::create(['name' => 'organizer']);

        $user->assignRole($role);
        $attendeeuser->assignRole($attendee);
        $organizeruser->assignRole($organizer);
        $organizerAttendeeUser->assignRole(['organizer', 'attendee']);

        // default menu create
        $menus = [
            [
                'user_id'    => $user->id,
                'parent_id'  => null,
                'name'       => 'Admin',
                'slug'       => 'admin',
                'route'      => '#',
                'url'        => null,
                'icon'       => '<svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="#6D4DFF" stroke-width="1.5" />
                        <path
                            d="M21.011 14.0966C21.5329 13.9559 21.7939 13.8855 21.8969 13.7509C22 13.6164 22 13.3999 22 12.967V11.0333C22 10.6004 22 10.3839 21.8969 10.2494C21.7938 10.1148 21.5329 10.0444 21.011 9.90365C19.0606 9.37766 17.8399 7.33858 18.3433 5.40094C18.4817 4.86806 18.5509 4.60163 18.4848 4.44536C18.4187 4.28909 18.2291 4.18141 17.8497 3.96603L16.125 2.9868C15.7528 2.77546 15.5667 2.66979 15.3997 2.69229C15.2326 2.71479 15.0442 2.9028 14.6672 3.2788C13.208 4.73455 10.7936 4.73449 9.33434 3.27871C8.95743 2.9027 8.76898 2.7147 8.60193 2.69219C8.43489 2.66969 8.24877 2.77536 7.87653 2.9867L6.15184 3.96594C5.77253 4.1813 5.58287 4.28898 5.51678 4.44522C5.45068 4.60147 5.51987 4.86794 5.65825 5.40087C6.16137 7.33857 4.93972 9.3777 2.98902 9.90367C2.46712 10.0444 2.20617 10.1148 2.10308 10.2493C2 10.3839 2 10.6004 2 11.0333V12.967C2 13.3999 2 13.6164 2.10308 13.7509C2.20615 13.8855 2.46711 13.9559 2.98902 14.0966C4.9394 14.6226 6.16008 16.6617 5.65672 18.5993C5.51829 19.1322 5.44907 19.3986 5.51516 19.5549C5.58126 19.7112 5.77092 19.8189 6.15025 20.0342L7.87495 21.0135C8.24721 21.2248 8.43334 21.3305 8.6004 21.308C8.76746 21.2855 8.95588 21.0974 9.33271 20.7214C10.7927 19.2645 13.2088 19.2644 14.6689 20.7213C15.0457 21.0974 15.2341 21.2854 15.4012 21.3079C15.5682 21.3304 15.7544 21.2247 16.1266 21.0134L17.8513 20.0341C18.2307 19.8188 18.4204 19.7111 18.4864 19.5548C18.5525 19.3985 18.4833 19.1321 18.3448 18.5992C17.8412 16.6617 19.0609 14.6227 21.011 14.0966Z"
                            stroke="#6D4DFF" stroke-width="1.5" stroke-linecap="round" />
                    </svg>',
                'roles'      => json_encode(['super-admin']),
                'status'     => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'order'      => 100,
            ],
            [
                'user_id'    => $user->id,
                'parent_id'  => 1,
                'name'       => 'Role',
                'slug'       => 'role',
                'route'      => 'dashboard.role.index',
                'url'        => 'dashboard/role-list',
                'icon'       => '<svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="#6D4DFF" stroke-width="1.5" />
                        <path
                            d="M21.011 14.0966C21.5329 13.9559 21.7939 13.8855 21.8969 13.7509C22 13.6164 22 13.3999 22 12.967V11.0333C22 10.6004 22 10.3839 21.8969 10.2494C21.7938 10.1148 21.5329 10.0444 21.011 9.90365C19.0606 9.37766 17.8399 7.33858 18.3433 5.40094C18.4817 4.86806 18.5509 4.60163 18.4848 4.44536C18.4187 4.28909 18.2291 4.18141 17.8497 3.96603L16.125 2.9868C15.7528 2.77546 15.5667 2.66979 15.3997 2.69229C15.2326 2.71479 15.0442 2.9028 14.6672 3.2788C13.208 4.73455 10.7936 4.73449 9.33434 3.27871C8.95743 2.9027 8.76898 2.7147 8.60193 2.69219C8.43489 2.66969 8.24877 2.77536 7.87653 2.9867L6.15184 3.96594C5.77253 4.1813 5.58287 4.28898 5.51678 4.44522C5.45068 4.60147 5.51987 4.86794 5.65825 5.40087C6.16137 7.33857 4.93972 9.3777 2.98902 9.90367C2.46712 10.0444 2.20617 10.1148 2.10308 10.2493C2 10.3839 2 10.6004 2 11.0333V12.967C2 13.3999 2 13.6164 2.10308 13.7509C2.20615 13.8855 2.46711 13.9559 2.98902 14.0966C4.9394 14.6226 6.16008 16.6617 5.65672 18.5993C5.51829 19.1322 5.44907 19.3986 5.51516 19.5549C5.58126 19.7112 5.77092 19.8189 6.15025 20.0342L7.87495 21.0135C8.24721 21.2248 8.43334 21.3305 8.6004 21.308C8.76746 21.2855 8.95588 21.0974 9.33271 20.7214C10.7927 19.2645 13.2088 19.2644 14.6689 20.7213C15.0457 21.0974 15.2341 21.2854 15.4012 21.3079C15.5682 21.3304 15.7544 21.2247 16.1266 21.0134L17.8513 20.0341C18.2307 19.8188 18.4204 19.7111 18.4864 19.5548C18.5525 19.3985 18.4833 19.1321 18.3448 18.5992C17.8412 16.6617 19.0609 14.6227 21.011 14.0966Z"
                            stroke="#6D4DFF" stroke-width="1.5" stroke-linecap="round" />
                    </svg>',
                'roles'      => json_encode(['super-admin']),
                'status'     => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'order'      => 2,
            ],
            [
                'user_id'    => $user->id,
                'parent_id'  => 1,
                'name'       => 'User',
                'slug'       => 'user',
                'route'      => 'admin.user.index',
                'url'        => 'admin/user',
                'icon'       => '<svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="#6D4DFF" stroke-width="1.5" />
                        <path
                            d="M21.011 14.0966C21.5329 13.9559 21.7939 13.8855 21.8969 13.7509C22 13.6164 22 13.3999 22 12.967V11.0333C22 10.6004 22 10.3839 21.8969 10.2494C21.7938 10.1148 21.5329 10.0444 21.011 9.90365C19.0606 9.37766 17.8399 7.33858 18.3433 5.40094C18.4817 4.86806 18.5509 4.60163 18.4848 4.44536C18.4187 4.28909 18.2291 4.18141 17.8497 3.96603L16.125 2.9868C15.7528 2.77546 15.5667 2.66979 15.3997 2.69229C15.2326 2.71479 15.0442 2.9028 14.6672 3.2788C13.208 4.73455 10.7936 4.73449 9.33434 3.27871C8.95743 2.9027 8.76898 2.7147 8.60193 2.69219C8.43489 2.66969 8.24877 2.77536 7.87653 2.9867L6.15184 3.96594C5.77253 4.1813 5.58287 4.28898 5.51678 4.44522C5.45068 4.60147 5.51987 4.86794 5.65825 5.40087C6.16137 7.33857 4.93972 9.3777 2.98902 9.90367C2.46712 10.0444 2.20617 10.1148 2.10308 10.2493C2 10.3839 2 10.6004 2 11.0333V12.967C2 13.3999 2 13.6164 2.10308 13.7509C2.20615 13.8855 2.46711 13.9559 2.98902 14.0966C4.9394 14.6226 6.16008 16.6617 5.65672 18.5993C5.51829 19.1322 5.44907 19.3986 5.51516 19.5549C5.58126 19.7112 5.77092 19.8189 6.15025 20.0342L7.87495 21.0135C8.24721 21.2248 8.43334 21.3305 8.6004 21.308C8.76746 21.2855 8.95588 21.0974 9.33271 20.7214C10.7927 19.2645 13.2088 19.2644 14.6689 20.7213C15.0457 21.0974 15.2341 21.2854 15.4012 21.3079C15.5682 21.3304 15.7544 21.2247 16.1266 21.0134L17.8513 20.0341C18.2307 19.8188 18.4204 19.7111 18.4864 19.5548C18.5525 19.3985 18.4833 19.1321 18.3448 18.5992C17.8412 16.6617 19.0609 14.6227 21.011 14.0966Z"
                            stroke="#6D4DFF" stroke-width="1.5" stroke-linecap="round" />
                    </svg>',
                'roles'      => json_encode(['super-admin']),
                'status'     => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'order'      => 1,
            ],
            [
                'user_id'    => $user->id,
                'parent_id'  => 1,
                'name'       => 'Menu',
                'slug'       => 'menu',
                'route'      => 'dashboard.menu.index',
                'url'        => 'dashboard/menu',
                'icon'       => '<svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="#6D4DFF" stroke-width="1.5" />
                        <path
                            d="M21.011 14.0966C21.5329 13.9559 21.7939 13.8855 21.8969 13.7509C22 13.6164 22 13.3999 22 12.967V11.0333C22 10.6004 22 10.3839 21.8969 10.2494C21.7938 10.1148 21.5329 10.0444 21.011 9.90365C19.0606 9.37766 17.8399 7.33858 18.3433 5.40094C18.4817 4.86806 18.5509 4.60163 18.4848 4.44536C18.4187 4.28909 18.2291 4.18141 17.8497 3.96603L16.125 2.9868C15.7528 2.77546 15.5667 2.66979 15.3997 2.69229C15.2326 2.71479 15.0442 2.9028 14.6672 3.2788C13.208 4.73455 10.7936 4.73449 9.33434 3.27871C8.95743 2.9027 8.76898 2.7147 8.60193 2.69219C8.43489 2.66969 8.24877 2.77536 7.87653 2.9867L6.15184 3.96594C5.77253 4.1813 5.58287 4.28898 5.51678 4.44522C5.45068 4.60147 5.51987 4.86794 5.65825 5.40087C6.16137 7.33857 4.93972 9.3777 2.98902 9.90367C2.46712 10.0444 2.20617 10.1148 2.10308 10.2493C2 10.3839 2 10.6004 2 11.0333V12.967C2 13.3999 2 13.6164 2.10308 13.7509C2.20615 13.8855 2.46711 13.9559 2.98902 14.0966C4.9394 14.6226 6.16008 16.6617 5.65672 18.5993C5.51829 19.1322 5.44907 19.3986 5.51516 19.5549C5.58126 19.7112 5.77092 19.8189 6.15025 20.0342L7.87495 21.0135C8.24721 21.2248 8.43334 21.3305 8.6004 21.308C8.76746 21.2855 8.95588 21.0974 9.33271 20.7214C10.7927 19.2645 13.2088 19.2644 14.6689 20.7213C15.0457 21.0974 15.2341 21.2854 15.4012 21.3079C15.5682 21.3304 15.7544 21.2247 16.1266 21.0134L17.8513 20.0341C18.2307 19.8188 18.4204 19.7111 18.4864 19.5548C18.5525 19.3985 18.4833 19.1321 18.3448 18.5992C17.8412 16.6617 19.0609 14.6227 21.011 14.0966Z"
                            stroke="#6D4DFF" stroke-width="1.5" stroke-linecap="round" />
                    </svg>',
                'roles'      => json_encode(['super-admin']),
                'status'     => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'order'      => 3,
            ],
            [
                'user_id'    => $user->id,
                'parent_id'  => 1,
                'name'       => 'Module',
                'slug'       => 'module',
                'route'      => 'dashboard.module.index',
                'url'        => 'dashboard/module/create',
                'icon'       => '<svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="#6D4DFF" stroke-width="1.5" />
                        <path
                            d="M21.011 14.0966C21.5329 13.9559 21.7939 13.8855 21.8969 13.7509C22 13.6164 22 13.3999 22 12.967V11.0333C22 10.6004 22 10.3839 21.8969 10.2494C21.7938 10.1148 21.5329 10.0444 21.011 9.90365C19.0606 9.37766 17.8399 7.33858 18.3433 5.40094C18.4817 4.86806 18.5509 4.60163 18.4848 4.44536C18.4187 4.28909 18.2291 4.18141 17.8497 3.96603L16.125 2.9868C15.7528 2.77546 15.5667 2.66979 15.3997 2.69229C15.2326 2.71479 15.0442 2.9028 14.6672 3.2788C13.208 4.73455 10.7936 4.73449 9.33434 3.27871C8.95743 2.9027 8.76898 2.7147 8.60193 2.69219C8.43489 2.66969 8.24877 2.77536 7.87653 2.9867L6.15184 3.96594C5.77253 4.1813 5.58287 4.28898 5.51678 4.44522C5.45068 4.60147 5.51987 4.86794 5.65825 5.40087C6.16137 7.33857 4.93972 9.3777 2.98902 9.90367C2.46712 10.0444 2.20617 10.1148 2.10308 10.2493C2 10.3839 2 10.6004 2 11.0333V12.967C2 13.3999 2 13.6164 2.10308 13.7509C2.20615 13.8855 2.46711 13.9559 2.98902 14.0966C4.9394 14.6226 6.16008 16.6617 5.65672 18.5993C5.51829 19.1322 5.44907 19.3986 5.51516 19.5549C5.58126 19.7112 5.77092 19.8189 6.15025 20.0342L7.87495 21.0135C8.24721 21.2248 8.43334 21.3305 8.6004 21.308C8.76746 21.2855 8.95588 21.0974 9.33271 20.7214C10.7927 19.2645 13.2088 19.2644 14.6689 20.7213C15.0457 21.0974 15.2341 21.2854 15.4012 21.3079C15.5682 21.3304 15.7544 21.2247 16.1266 21.0134L17.8513 20.0341C18.2307 19.8188 18.4204 19.7111 18.4864 19.5548C18.5525 19.3985 18.4833 19.1321 18.3448 18.5992C17.8412 16.6617 19.0609 14.6227 21.011 14.0966Z"
                            stroke="#6D4DFF" stroke-width="1.5" stroke-linecap="round" />
                    </svg>',
                'roles'      => json_encode(['super-admin']),
                'status'     => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'order'      => 4,
            ],
        ];
        Menu::insert($menus);

        // create module
        $module = [
            [
                'name'               => 'User',
                'slug'               => 'user',
                'permission'         => 1,
                'view'               => 1,
                'livewire_component' => 1,
                'mcrp'               => 1,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'name'               => 'Role',
                'slug'               => 'role',
                'permission'         => 1,
                'view'               => 1,
                'livewire_component' => 1,
                'mcrp'               => 1,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'name'               => 'Menu',
                'slug'               => 'menu',
                'permission'         => 1,
                'view'               => 1,
                'livewire_component' => 1,
                'mcrp'               => 1,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'name'               => 'Module',
                'slug'               => 'module',
                'permission'         => 1,
                'view'               => 1,
                'livewire_component' => 1,
                'mcrp'               => 1,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
        ];
        Module::insert($module);

        // create default permission
        $permissions = [
            [
                'module_id'  => 1,
                'name'       => 'user view list',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 1,
                'name'       => 'user create',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 1,
                'name'       => 'user update',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 1,
                'name'       => 'user delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 1,
                'name'       => 'user restore',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 1,
                'name'       => 'user force delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role view list',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role create',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role update',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role restore',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 2,
                'name'       => 'role force delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu view list',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu create',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu update',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu restore',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 3,
                'name'       => 'menu force delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module view list',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module create',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module update',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module restore',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_id'  => 4,
                'name'       => 'module force delete',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Permission::insert($permissions);

    }
}
