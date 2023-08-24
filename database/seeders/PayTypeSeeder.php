<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Monthly',
            ],
            [
                'id' => 2,
                'name' => 'Quarterly',
            ],
            [
                'id' => 3,
                'name' => 'Semi-Annual',
            ],
            [
                'id' => 4,
                'name' => 'Annual',
            ],
            [
                'id' => 5,
                'name' => 'Spot Payment',
            ],
            [
                'id' => 6,
                'name' => 'Spot Service',
            ],
        ];

        foreach($data as $row) {
            \App\Models\PayType::create($row);
        }
    }
}
