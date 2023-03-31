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
          'username' => 'admin',
          'email'    => 'admin@gmail.com',
          'phone'    => 9978663855,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 2, //admin,
        ],
        [
          'username' => 'manager',
          'email'    => 'manager@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 3, //manager
        ],
        [
          'username' => 'agent',
          'email'    => 'agent@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 4, //agent
        ],
        [
          'username' => 'staff',
          'email'    => 'staff@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 5, //staff
        ],
        [
          'username' => 'client',
          'email'    => 'client@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 6, //client
        ],
        [
          'username' => 'inactive',
          'email'    => 'inactive@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 0, //inactive
        ],
        [
          'username' => 'banned',
          'email'    => 'banned@gmail.com',
          'phone'    => 1234567890,
          'password' => Hash::make('12345678'),
          'avatar'   => 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png',
          'role'     => 1, //inactive
        ],
      ];

      foreach($data as $row) {
        \App\Models\User::create($row);
      }
    }
}
