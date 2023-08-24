<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE ADMIN
        User::create([
            'id'=> 2,
            'region_id'=> null,
            'branch_id'=> null,
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
            'role'     => 2,
        ])->assignRole('admin');

        // NOTE MANAGER
        // >>>

        // NOTE AGENT
        User::create([
            'id'=> 4,
            'region_id'=> 1,
            'branch_id'=> 1,
            'username' => 'agent',
            'email'    => 'agent@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
            'role'     => 4,
        ])->assignRole('agent');

        // NOTE STAFF
        User::create([
            'id'=> 5,
            'region_id'=> 1,
            'branch_id'=> 1,
            'username' => 'staff',
            'email'    => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
            'role'     => 5,
        ])->assignRole('staff');

        // NOTE CLIENT
        User::create([
            'id'=> 6,
            'region_id'=> 1,
            'branch_id'=> 1,
            'username' => 'client',
            'email'    => 'client@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
            'role'     => 6,
        ])->assignRole('client');

        // NOTE CLIENTS DUMMY
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
        foreach(range(1,10) as $idx) {
            \App\Models\User::create([
                'id'=> $idx + 7,
                'region_id'=> 1,
                'branch_id'=> 1,
                'username' => $faker->username,
                'avatar'   => $faker->gravatarUrl(),
                'email'    => $faker->email,
                'password' => Hash::make('12345678'),
                'role'     => 6,
            ])->assignRole('client');
        }
    }
}
