<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles
        Role::insert(['title' => 'Admin', 'created_at' => now()]);
        Role::insert(['title' => 'User', 'created_at' => now()]);

        // Assigns role to users
        User::findOrFail(2)->roles()->sync(1); // user Admin
        User::findOrFail(3)->roles()->sync(2); // user User
    }
}
