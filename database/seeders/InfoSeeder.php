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
                'user_id'   => env('SEEDER_USER_AGENT_ID', null),
                'staff_id'  => env('SEEDER_USER_STAFF_ID', null),
                'agent_id'  => env('SEEDER_USER_AGENT_ID', null),
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'agent address',
                'pay_type_id'=> env("SEEDER_PAY_TYPE_MONTHLY_ID", null),
                'plan_details_id'    => env('SEEDER_PLAN_JASPER_ID', null),
            ],
            [
                'user_id'   => env('SEEDER_USER_CLIENT_ID'),
                'staff_id'  => env('SEEDER_USER_STAFF_ID', null),
                'agent_id'  => env('SEEDER_USER_AGENT_ID', null),
                'bday'      => Carbon::today()->subDays(rand(0, 365)),
                'bplace_id' => 1,
                'sex'       => false,
                'address_id'=> 1,
                'address'   => 'client address',
                'pay_type_id'=> env("SEEDER_PAY_TYPE_MONTHLY_ID", null),
                'plan_details_id'    => env('SEEDER_PLAN_JASPER_ID', null),
            ],
        ];

        foreach($data as $row) {
            \App\Models\Info::create($row);
        }
    }
}
