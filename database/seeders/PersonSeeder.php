<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'id' => 1,
          'created_by_user_id' => 1,
          'lastName' => '[LastAdmin]',
          'firstName' => '[firstAdmin]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 2,
          'created_by_user_id' => 1,
          'lastName' => '[LastManager]',
          'firstName' => '[firstManager]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 3,
          'created_by_user_id' => 1,
          'lastName' => '[LastAgent]',
          'firstName' => '[LastAgent]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 4,
          'created_by_user_id' => 1,
          'lastName' => '[LastStaff]',
          'firstName' => '[LastStaff]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 5,
          'created_by_user_id' => 1,
          'lastName' => '[LastClient]',
          'firstName' => '[LastClient]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 6,
          'created_by_user_id' => 1,
          'lastName' => '[LastInactive]',
          'firstName' => '[LastInactive]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
        [
          'id' => 7,
          'created_by_user_id' => 1,
          'lastName' => '[LastBanned]',
          'firstName' => '[LastBanned]',
          'midName' => '[midName]',
          'extName' => '[extName]',
          'bday' => '2022-02-02',
          'bplace_id' => 1,
          'sex' => true,
          'address_id' => 1,
          'address' => '[address]'
        ],
      ];

      foreach($data as $row) {
        \App\Models\Person::create($row);
      }

      $faker = \Faker\Factory::create();
      foreach(range(1,100) as $idx) {
        \App\Models\Person::create([
          'created_by_user_id' => 1,
          'lastName' => $faker->name,
          'firstName'=> $faker->name,
          'midName'  => $faker->name,
          'extName'  => $faker->name,
          'bday'     => '2022-02-02',
          'bplace_id'=> 1,
          'sex'      => true,
          'address_id' => 1,
          'address'  => '[address]',
        ]);
      }
    }
}
