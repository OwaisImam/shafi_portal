<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-permission-routes';

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


        $permissions = [
                  'users',
                  'permissions',
                  'clients',
                  'email_templates',
                  'departments'
              ];

        $permissionList = [];

        foreach ($permissions as $permission) {
            // Generate permission names for CRUD operations
            $permissionList[] = $permission . '-list';
            $permissionList[] = $permission . '-create';
            $permissionList[] = $permission . '-edit';
            $permissionList[] = $permission . '-view';
            $permissionList[] = $permission . '-delete';

            if($permission == 'clients') {
                $permissionList[] = $permission . '-generate-credentials';
            }
        }

        foreach ($permissionList as $permission) {
            $exist = Permission::where('name', $permission)->first();

            if (!$exist) {
                Permission::create(['name' => $permission]);
            }
        }

        $permissions = Permission::all()->pluck('name');
        $role = Role::where('name', 'admin')->first();
        $role->syncPermissions($permissions);

        $this->info('Permission routes added successfully.');

    }
}