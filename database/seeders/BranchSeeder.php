<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'name' => 'Valencia City'
        ]
      ];

      foreach($data as $row) {
        \App\Models\Branch::create($row);
      }
    }
}
