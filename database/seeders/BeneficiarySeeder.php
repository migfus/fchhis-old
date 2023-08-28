<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Beneficiary::create([
            // 'id' => 569913448810123,
            'user_id' => env('SEEDER_USER_CLIENT_ID', null),
            'name' => 'Beneficiary 1',
            'bday' => Carbon::now(),
        ]);

        \App\Models\Beneficiary::create([
            // 'id' => 569913448822843,
            'user_id' => env('SEEDER_USER_CLIENT_ID', null),
            'name' => 'Beneficiary 2',
            'bday' => Carbon::now(),
        ]);
    }
}
