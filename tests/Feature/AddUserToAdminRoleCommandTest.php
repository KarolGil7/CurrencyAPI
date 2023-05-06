<?php

namespace Tests\Feature;

use App\Helpers\PermissionRolesHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Tests\CustomTestCase;

class AddUserToAdminRoleCommandTest extends CustomTestCase
{
    /** @test */
    public function test_adds_user_to_admin_role()
    {
        $user = User::factory()->create();

        Artisan::call('app:add-user-to-admin-role', ['id' => $user->id]);

        $user->refresh();

        $this->assertTrue($user->hasRole(PermissionRolesHelper::ADMIN_ROLE));
    }

    /** @test */
    public function test_fails_to_add_user_to_admin_role()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->artisan('app:add-user-to-admin-role 1234');
    }
}
