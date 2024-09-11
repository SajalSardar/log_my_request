<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        $role      = Role::create(['name' => 'super-admin']);
        $attendee  = Role::create(['name' => 'attendee']);
        $organizer = Role::create(['name' => 'organizer']);

        $user->assignRole($role);
        $attendeeuser->assignRole($attendee);
        $organizeruser->assignRole($organizer);

    }
}
