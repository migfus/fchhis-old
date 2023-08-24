<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SECTION PERMISSIONS
            // SECTION AUTH
            // NOTE FOR NOT BANNED USER
            Permission::create(['name' => 'index auth']);
            // NOTE ABLE TO UPDATE PROFILE
            Permission::create(['name' => 'update auth']);



        // SECTION ADMIN
        $role = Role::create(['name' => 'admin']);
            $role->givePermissionTo([
                'index auth', 'update auth'
            ]);

        // SECTION MANAGER
        $role = Role::create(['name' => 'manager']);
            $role->givePermissionTo([
                'index auth', 'update auth'
            ]);

        // SECTION STAFF
        $role = Role::create(['name' => 'staff']);
            $role->givePermissionTo([
                'index auth', 'update auth'
            ]);

        // SECTION AGENT
        $role = Role::create(['name' => 'agent']);
            $role->givePermissionTo([
                'index auth', 'update auth'
            ]);

        // SECTION CLIENT
        $role = Role::create(['name' => 'client']);
            $role->givePermissionTo([
                'index auth', 'update auth'
            ]);
    }
}
