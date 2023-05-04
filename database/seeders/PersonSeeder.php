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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
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
          'address' => '[address]',
          'mobile' => 9978885555,
          'agent_id'=> 3,
        ],
      ];

      foreach($data as $row) {
        \App\Models\Person::create($row);
      }

      $faker = \Faker\Factory::create();
      foreach(range(1,100) as $idx) {
        \App\Models\Person::create([
          'created_by_user_id' => 1,
          'lastName' => $faker->lastName,
          'firstName'=> $faker->firstName,
          'midName'  => $faker->randomLetter,
          'extName'  => 'Jr',
          'bday'     => '2022-02-02',
          'bplace_id'=> $idx,
          'sex'      => true,
          'address_id' => $idx,
          'address'  => $faker->lastName,
          'mobile' => 9978885555,
          'agent_id'=> rand(1, 6),
        ]);
      }
    }
}
