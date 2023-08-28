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

            // SECTION USERS
            Permission::create(['name' => 'index client']);



        // SECTION ADMIN
        $role = Role::create(['name' => 'admin']);
            $role->givePermissionTo([
                'index auth', 'update auth',
                'index client'
            ]);

        // SECTION MANAGER
        $role = Role::create(['name' => 'regional_manager']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);
        $role = Role::create(['name' => 'branch_manager']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);

        // SECTION STAFF
        $role = Role::create(['name' => 'staff']);
            $role->givePermissionTo([
                'index auth', 'update auth',
                'index client'
            ]);

        // SECTION AGENT
        $role = Role::create(['name' => 'agent']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);

        // SECTION CLIENT
        $role = Role::create(['name' => 'client']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);

        // SECTION DECEASED
        $role = Role::create(['name' => 'deceased']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);

        // SECTION CLAIMED
        $role = Role::create(['name' => 'claimed']);
            $role->givePermissionTo([
                'index auth', 'update auth',
            ]);
    }
}
