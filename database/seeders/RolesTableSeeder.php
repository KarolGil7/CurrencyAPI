<?php

namespace Database\Seeders;

use App\Helpers\PermissionRolesHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => PermissionRolesHelper::USER_ROLE]);
        Role::create(['name' => PermissionRolesHelper::ADMIN_ROLE]);
    }
}
