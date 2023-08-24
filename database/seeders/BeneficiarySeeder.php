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
            'user_id' => 6,
            'name' => 'Beneficiary 1',
            'bday' => Carbon::now(),
        ]);

        \App\Models\Beneficiary::create([
            'user_id' => 6,
            'name' => 'Beneficiary 2',
            'bday' => Carbon::now(),
        ]);
    }
}
