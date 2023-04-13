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
          'username' => 'admin',
          'email'    => 'admin@gmail.com',
          'phone'    => 9978663855,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 2, //admin,
        ],
        [
          'person_id'=> 2,
          'username' => 'manager',
          'email'    => 'manager@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 3, //manager
        ],
        [
          'person_id'=> 3,
          'username' => 'agent',
          'email'    => 'agent@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 4, //agent
        ],
        [
          'person_id'=> 4,
          'username' => 'staff',
          'email'    => 'staff@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 5, //staff
        ],
        [
          'person_id'=> 5,
          'username' => 'client',
          'email'    => 'client@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 6, //client
        ],
        [
          'person_id'=> 6,
          'username' => 'inactive',
          'email'    => 'inactive@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 0, //inactive
        ],
        [
          'person_id'=> 7,
          'username' => 'banned',
          'email'    => 'banned@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 1, //banned
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
          'username' => $faker->username,
          'avatar'   => $faker->gravatarUrl(),
          'email'    => $faker->email,
          'phone'    => rand(1111111111, 9999999999),
          'password' => Hash::make('12345678'),
          'role'     => 6
        ]);
      }
    }
}
