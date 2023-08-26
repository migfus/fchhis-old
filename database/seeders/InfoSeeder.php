<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'        => 4,
                'user_id'   => 4,
                'staff_id'  => 1,
                'agent_id'  => 1,
                'name'      => '[agent]',
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'agent address'
            ],
            [
                'id'        => 6,
                'user_id'   => 6,
                'staff_id'  => 1,
                'agent_id'  => 1,
                'name'      => '[client]',
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'client address',
                'pay_type_id'=> 1,
                'plan_id'    => 1,
            ],
            [
                'id'        => 3,
                'user_id'   => 3,
                'staff_id'  => 5,
                'agent_id'  => 4,
                'pay_type_id'=>1,
                'plan_id'   => 1,
                'name'      => '[client due]',
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'client-due address',
                'due_at'    => Carbon::now(),
            ],
        ];

        foreach($data as $row) {
            \App\Models\Info::create($row);
        }

        $faker = \Faker\Factory::create();
        foreach(range(1,10) as $idx) {
            \App\Models\Info::create([
                'id' => $idx + 7,
                'user_id'   => $idx + 7,
                'staff_id' => 5,
                'agent_id' => 4,
                'pay_type_id' => rand(1,6),
                'plan_id'  => rand(1,4),
                'name'     => $faker->name,
                'bday'     => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex' => false,
                'address_id' => 1,
                'address'  => '[street]'
                // 'due_at' => Carbon::now(),
            ]);
        }
    }
}
