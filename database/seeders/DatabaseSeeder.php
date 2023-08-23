<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      $this->call([
        RegionSeeder::class,
        BranchSeeder::class,

        UserSeeder::class,
        PersonSeeder::class,

        PlanSeeder::class,
        TransactionSeeder::class,
        PayTypeSeeder::class,

        AddressSQL::class,
      ]);
    }
}
