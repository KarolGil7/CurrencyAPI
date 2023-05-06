<?php

namespace App\Console\Commands;

use App\Helpers\PermissionRolesHelper;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddUserToAdminRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-user-to-admin-role {id : The ID of the user to add}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to admin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::findOrFail($this->argument('id'));

        $adminRole = Role::where('name', PermissionRolesHelper::ADMIN_ROLE)->firstOrFail();

        if($user && $adminRole)
        {
            $user->assignRole($adminRole);

            $this->info("User ID {$user->id} has been added to the admin role.");
            return;
        }

        $this->error("Something went wrong");
  }
}
