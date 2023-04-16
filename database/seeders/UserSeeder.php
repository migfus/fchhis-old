<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
      $data = [
        [
          'person_id'=> 1,
          'plan_id'  => 1,
          'username' => 'admin',
          'email'    => 'admin@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 2, //admin,
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 2,
          'plan_id'  => 2,
          'username' => 'manager',
          'email'    => 'manager@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 3, //manager
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 3,
          'plan_id'  => 3,
          'username' => 'agent',
          'email'    => 'agent@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 4, //agent
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 4,
          'plan_id'  => 4,
          'username' => 'staff',
          'email'    => 'staff@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 5, //staff
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 5,
          'plan_id'  => 2,
          'username' => 'client',
          'email'    => 'client@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 6, //client
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 6,
          'plan_id'  => 3,
          'username' => 'inactive',
          'email'    => 'inactive@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 0, //inactive
          'notify_mobile' => true,
        ],
        [
          'person_id'=> 7,
          'plan_id'  => 4,
          'username' => 'banned',
          'email'    => 'banned@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 1, //banned
          'notify_mobile' => true,
        ],

        // [
        //   'username' => 'client',
        //   'email'    => 'banned@gmail.com',
        //   'phone'    => 1234567890,
        //   'password' => Hash::make('12345678'),
        //   'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
        //   'role'     => 1, //banned
        // ],
      ];

      foreach($data as $row) {
        \App\Models\User::create($row);
      }

      $faker = \Faker\Factory::create();
      $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
      foreach(range(1,100) as $idx) {
        \App\Models\User::create([
          'person_id'=> $idx + 7,
          'plan_id'  => 1,
          'username' => $faker->username,
          'avatar'   => $faker->gravatarUrl(),
          'email'    => $faker->email,
          'password' => Hash::make('12345678'),
          'role'     => 6,
          'notify_mobile' => true,
        ]);
      }
    }
}
