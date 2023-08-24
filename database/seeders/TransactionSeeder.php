<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'or' => '123456-123456',
                'agent_id' => 1,
                'staff_id' => 2,
                'client_id' => 6,
                'plan_id' => 1,
                'amount' => 1250,
                'pay_type_id' => 2, // querterly
            ],
        ];

        foreach($data as $row) {
            \App\Models\Transaction::create($row);
        }

        $faker = \Faker\Factory::create();
        foreach(range(1,100) as $idx) {
            $pay_type_id = rand(1,6);

            \App\Models\Transaction::create([
                'or'       => rand(1000, 100000),
                'agent_id' => $idx + 1,
                'staff_id' => 5,
                'client_id' => $idx + 2,
                'plan_id' => rand(1,4),
                'amount' => rand(700, 75000),
                'pay_type_id' => $pay_type_id,
            ]);
        }
    }
}
