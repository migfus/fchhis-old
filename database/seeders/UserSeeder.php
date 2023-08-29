<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE ADMIN
        User::create([
            'id'=> env('SEEDER_USER_ADMIN_ID', 569914608193917),
            'region_id'=> null,
            'branch_id'=> null,
            'username' => 'admin',
            'name'     => 'admin name',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('admin');

        // NOTE MANAGER
        User::create([
            'id'=> env('SEEDER_USER_REGIONAL_MANAGER_ID', 569914608521972),
            'region_id'=> env('SEEDER_REGION_X_ID', null),
            'branch_id'=> null,
            'username' => 'regionalmanager',
            'name'     => 'admin name',
            'email'    => 'regionalmanager@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('regional_manager');

        User::create([
            'id'=> env('SEEDER_USER_BRANCH_MANAGER_ID', 569914608859162),
            'region_id'=> env('SEEDER_REGION_X_ID', null),
            'branch_id'=> env('SEEDER_BRANCH_VALENCIA_ID', null),
            'username' => 'branchmanager',
            'name'     => 'branch manager',
            'email'    => 'branchmanager@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('branch_manager');

        // NOTE STAFF
        User::create([
            'id'=> env('SEEDER_USER_STAFF_ID', 569914609518872),
            'region_id'=> env('SEEDER_REGION_X_ID', null),
            'branch_id'=> env('SEEDER_BRANCH_VALENCIA_ID', null),
            'username' => 'staff',
            'name'     => 'staff name',
            'email'    => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('staff');

        // NOTE AGENT
        User::create([
            'id'=> env('SEEDER_USER_AGENT_ID', 569914609196675),
            'region_id'=> env('SEEDER_REGION_X_ID', null),
            'branch_id'=> env('SEEDER_BRANCH_VALENCIA_ID', null),
            'username' => 'agent',
            'name'     => 'agent name',
            'email'    => 'agent@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('agent');

        // NOTE CLIENT
        User::create([
            'id'=> env('SEEDER_USER_CLIENT_ID', 569914609832999),
            'region_id'=> env('SEEDER_REGION_X_ID', null),
            'branch_id'=> env('SEEDER_BRANCH_VALENCIA_ID', null),
            'username' => 'client',
            'name'     => 'client name',
            'email'    => 'client@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        ])->assignRole('client');

        // NOTE CLIENTS DUMMY
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
        foreach(range(1,10) as $idx) {
            $user = \App\Models\User::create([
                // 'id'=> $idx + 10,
                'region_id'=> env('SEEDER_REGION_X_ID', null),
                'branch_id'=> env('SEEDER_BRANCH_VALENCIA_ID', null),
                'username' => $faker->username,
                'name'     => $faker->name,
                'avatar'   => $faker->gravatarUrl(),
                'email'    => $faker->email,
                'password' => Hash::make('12345678'),
            ])->assignRole('client');

            \App\Models\Info::create([
                'user_id'   => $user->id,
                'staff_id'  => env('SEEDER_USER_STAFF_ID', null),
                'agent_id'  => env('SEEDER_USER_AGENT_ID', null),
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'client address',
                'pay_type_id'=> env("SEEDER_PAY_TYPE_MONTHLY_ID", null),
                'plan_id'    => env('SEEDER_PLAN_JASPER_ID', null),
                'due_at'    => Carbon::today()->addDays()

            ]);
        }
    }
}
