<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [
      [
        'agent_id' => 1,
        'staff_id' => 2,
        'client_id' => 1,
        'plan_id' => 1,
        'amount' => 1250,
      ],
    ];

    foreach($data as $row) {
      \App\Models\Transaction::create($row);
    }

    $faker = \Faker\Factory::create();
    foreach(range(1,100) as $idx) {
      \App\Models\Transaction::create([
        'agent_id' => $idx + 1,
        'staff_id' => $idx + 3,
        'client_id' => $idx + 2,
        'plan_id' => rand(1,4),
        'amount' => rand(700, 75000),
      ]);
    }
  }
}
