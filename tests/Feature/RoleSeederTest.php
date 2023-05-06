<?php

namespace Tests\Feature;

use Spatie\Permission\Models\Role;
use Tests\CustomTestCase;

class RoleSeederTest extends CustomTestCase
{
    /** @test */
    public function test_user_role_and_admin_role_are_seeded(): void
    {
        /**
         * Names entered manually,
         * not with PermissionRolesHelper::USER_ROLE
         * to check that no one has changed the role names.
         * (Maintaining data consistency).
         */

        $userRole = Role::where('name', '=', 'userRole')->first();

        $adminRole = Role::where('name', '=', 'adminRole')->first();

        $this->assertNotNull($userRole, 'userRole not seed');
        $this->assertNotNull($adminRole, 'adminRole not seed');
    }
}
