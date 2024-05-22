<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('name', 'admin')->first();

        if ($user) {

            $role = Role::where('name', 'admin')->first();

            if ($role) {
                $user->assignRole($role);
            } else {
                $role = Role::create(['name' => 'admin']);
                $user->assignRole($role);
            }

        } else {

            $user = User::create([
                        'name' => 'admin',
                        'dob' => '2000-10-10',
                        'email' => 'owaisimam2@gmail.com',
                        'password' => Hash::make('12345678'),
                        'email_verified_at' => '2022-01-02 17:04:58',
                        'avatar' => 'images/avatar-1.jpg',
                        'created_at' => now(),
                    ]);

            $role = Role::where('name', 'admin')->first();

            if ($role) {
                $user->assignRole($role);
            } else {
                $role = Role::create(['name' => 'admin']);
                $user->assignRole($role);
            }
        }
    }
}
