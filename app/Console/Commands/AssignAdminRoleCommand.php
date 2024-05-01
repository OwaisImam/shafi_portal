<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignAdminRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign-admin-role {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();

        $role = Role::where(['name' => 'admin'])->first();

        $permissions = Permission::pluck('id', 'id')->all();

        if($role) {
            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
        } else {

            $role = Role::create(['name' => 'admin']);

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
        }
    }
}
