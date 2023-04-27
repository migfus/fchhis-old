<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'person_id' => 5,
          'lastName' => 'John',
          'firstName' => 'Juan',
          'midName' => 'N',
          'extName' => '',
        ],
      ];

      foreach($data as $row) {
        \App\Models\Beneficiary::create($row);
      }
    }
}
