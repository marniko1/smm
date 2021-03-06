<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Create']);
        Permission::create(['name' => 'Read']);
        Permission::create(['name' => 'Update']);
        Permission::create(['name' => 'Delete']);

        // create roles and assign created permissions

        // this can be done as separate statements
        //$role = Role::create(['name' => 'writer']);
        //$role->givePermissionTo('edit articles');

        // or may be done by chaining
        //$role = Role::create(['name' => 'moderator'])
            //->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());
    }
}
