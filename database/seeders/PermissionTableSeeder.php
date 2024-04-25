<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'users',
            'roles',
            'permissions'
        ];

        $permissionList = [];

        foreach ($permissions as $permission) {
            // Generate permission names for CRUD operations
            $permissionList[] = $permission . '-list';
            $permissionList[] = $permission . '-create';
            $permissionList[] = $permission . '-edit';
            $permissionList[] = $permission . '-view';
            $permissionList[] = $permission . '-delete';
        }

        foreach ($permissionList as $permission) {
            $exist = Permission::where('name', $permission)->first();

            if (!$exist) {
                Permission::create(['name' => $permission]);
            }
        }

        $permissions = Permission::all()->pluck('name');
        $role = Role::where('name', 'Super Admin')->first();
        $role->syncPermissions($permissions);
    }
}