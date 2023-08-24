<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
        [
            'name' => 'Region X',
        ]
        ];

        foreach($data as $row) {
            \App\Models\Region::create($row);
        }
    }
}
