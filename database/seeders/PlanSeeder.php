<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'id'   => 1,
          'user_id' => 1,
          'avatar' => 'https://media.karousell.com/media/photos/products/2021/9/2/red_jasper_stone_raw_1630563781_5fe20000.jpg',
          'name' => 'Jasper',
          'age_start'=> 18,
          'age_end'  => 70,
          'desc' => 'For Non-Insured Person always pay the balance -71 & up.',
          'contract_price' => 27000,
          'spot_pay' => 26000,
          'spot_service' => 28000,
          'annual' => 5064,
          'semi_annual' => 2532,
          'quarterly' => 1266,
          'monthly' => 450,
        ],
        [
          'id'   => 2,
          'user_id' => 1,
          'avatar' => 'https://cdn.shopify.com/s/files/1/0273/4214/3566/files/Untitled_design_-_2020-09-03T160021.639.jpg?v=1599145227',
          'name' => 'Jade',
          'age_start'=> 18,
          'age_end'  => 70,
          'desc' => '',
          'contract_price' => 29700,
          'spot_pay' => 27000,
          'spot_service' => 29000,
          'annual' => 5556,
          'semi_annual' => 2778,
          'quarterly' => 1389,
          'monthly' => 495,
        ],
        [
          'id'   => 3,
          'user_id' => 1,
          'avatar' => 'https://gem-a.com/media/k2/items/cache/9139b86f02108abdcc0129521eca5e85_L.jpg',
          'name' => 'Beryl',
          'age_start'=> 18,
          'age_end'  => 70,
          'desc' => '',
          'contract_price' => 39000,
          'spot_pay' => 30000,
          'spot_service' => 33000,
          'annual' => 7320,
          'semi_annual' => 3660,
          'quarterly' => 1830,
          'monthly' => 650,
        ],
        [
          'id'   => 4,
          'user_id' => 1,
          'avatar' => 'https://cdn.shopify.com/s/files/1/0273/4214/3566/files/Untitled_design.jpg?v=1626279061',
          'name' => 'Onyx',
          'age_start'=> 18,
          'age_end'  => 70,
          'desc' => 'The Wooder Full Glass (Dual Memorial Package)',
          'contract_price' => 78000,
          'spot_pay' => 68000,
          'spot_service' => 73000,
          'annual' => 14640,
          'semi_annual' => 7320,
          'quarterly' => 3660,
          'monthly' => 1300,
        ]
      ];

      foreach($data as $row) {
        \App\Models\Plan::create($row);
      }
    }
}
