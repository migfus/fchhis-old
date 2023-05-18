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
          'person_id'=> 2,
          'username' => 'admin',
          'email'    => 'admin@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 2,
        ],
        [
          'person_id'=> 4,
          'username' => 'agent',
          'email'    => 'agent@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 4,
        ],
        [
          'person_id'=> 5,
          'username' => 'staff',
          'email'    => 'staff@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 5,
        ],
        [
          'person_id'=> 3,
          'username' => 'client-expired',
          'email'    => 'client-expired@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 6,
        ],
        [
          'person_id'=> 6,
          'username' => 'client',
          'email'    => 'client@gmail.com',
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 6,
        ]
      ];

      foreach($data as $row) {
        \App\Models\User::create($row);
      }

      $faker = \Faker\Factory::create();
      $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
      foreach(range(1,10) as $idx) {
        \App\Models\User::create([
          'person_id'=> $idx + 7,
          'username' => $faker->username,
          'avatar'   => $faker->gravatarUrl(),
          'email'    => $faker->email,
          'password' => Hash::make('12345678'),
          'role'     => 6,
        ]);
      }
    }
}
