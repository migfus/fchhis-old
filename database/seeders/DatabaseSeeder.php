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
            RoleAndPermissionSeeder::class,

            UserSeeder::class,
            InfoSeeder::class,
            BeneficiarySeeder::class,

            PlanSeeder::class,
            TransactionSeeder::class,
            PayTypeSeeder::class,

            AddressSQL::class,
        ]);
    }
}
