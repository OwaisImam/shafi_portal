<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-permission';

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
                  'departments',
                  'system_settings',
                  'category',
                  'items',
                  'suppliers',
                  'purchase_order',
                  'range',
                  'fabric_construction',
                  'payment_terms',
                  'article',
                  'orders',
                  'job',
                  'count',
                  'fiber',
                  'mills',
                  'terms_of_delivery',
                  'yarn_purchase_order',
                  'agents',
                  'pre_production_plan',
                  'dyeing',
                  'knitting',
                  'cartage_slip',
                  'yarn_stock',
                  'yarn_program',
                  'knitting_program',
              ];

        $permissionList = [];

        foreach ($permissions as $permission) {
            if(in_array($permission, ['yarn_stock'])) {
                $permissionList[] = $permission . '-list';
            } else {
                // Generate permission names for CRUD operations
                $permissionList[] = $permission . '-list';
                $permissionList[] = $permission . '-create';
                $permissionList[] = $permission . '-edit';
                $permissionList[] = $permission . '-view';
                $permissionList[] = $permission . '-delete';
            }
            if ($permission == 'clients') {
                $permissionList[] = $permission . '-generate-credentials';
            }

            if($permission == 'orders') {
                $permissionList[] = $permission. '-update-status';
            }

            if($permission == 'yarn_purchase_order') {
                $permissionList[] = $permission. '-receiving';
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