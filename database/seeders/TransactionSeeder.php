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
                'agent_id' => env('SEEDER_USER_AGENT_ID', null),
                'staff_id' => env('SEEDER_USER_STAFF_ID', null),
                'client_id' => env('SEEDER_USER_STAFF_ID', null),
                'plan_id' => env('SEEDER_PLAN_JASPER_ID', null),
                'amount' => 1250,
                'pay_type_id' => env('SEEDER_PAY_TYPE_QUARTERLY_ID', null), // querterly
            ],
        ];

        foreach($data as $row) {
            \App\Models\Transaction::create($row);
        }

        // $faker = \Faker\Factory::create();
        // foreach(range(1,100) as $idx) {
        //     $pay_type_id = rand(1,6);

        //     \App\Models\Transaction::create([
        //         'or'       => rand(1000, 100000),
        //         'agent_id' => $idx + 1,
        //         'staff_id' => 5,
        //         'client_id' => $idx + 2,
        //         'plan_id' => rand(1,4),
        //         'amount' => rand(700, 75000),
        //         'pay_type_id' => $pay_type_id,
        //     ]);
        // }
    }
}
