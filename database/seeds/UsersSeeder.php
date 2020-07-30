<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gennix.test',
            'password' => Hash::make('superman'),
            'active' => true,
            'is_superadmin' => true,
            'position' => 'Super Administrator',
            'created_at' => now(),
        ]);
        $user = User::find(1);
        $user->addMedia(public_path('img/avatars/avatar_0101.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');

        $user = User::insert([
            'name' => 'Peter Martins',
            'email' => 'admin@gennix.test',
            'password' => Hash::make('12345678'),
            'active' => false,
            'is_superadmin' => false,
            'position' => 'Administrator',
            'created_at' => now(),
        ]);
        $user = User::find(2);
        $user->addMedia(public_path('img/avatars/avatar_0112.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');


        $user = User::insert([
            'name' => 'Jane Garcez',
            'email' => 'user@gennix.test',
            'password' => Hash::make('12345678'),
            'active' => true,
            'is_superadmin' => false,
            'position' => 'Developer',
            'gender' => 'F',
            'created_at' => now(),
        ]);
        $user = User::find(3);
        $user->addMedia(public_path('img/avatars/avatar_0516.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');
    }
}
