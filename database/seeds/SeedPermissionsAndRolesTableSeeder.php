<?php

//namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeedPermissionsAndRolesTableSeeder extends Seeder
{
  public function run()
  {
    // Добавлял через Tinker
   
    /*
    // Reset cached roles and permissions
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Spatie\Permission\Models\Permission::create(['name' => 'create deal']);
    Spatie\Permission\Models\Permission::create(['name' => 'edit deal']);
    Spatie\Permission\Models\Permission::create(['name' => 'accept deal']);
    Spatie\Permission\Models\Permission::create(['name' => 'delete deal']);
    Spatie\Permission\Models\Permission::create(['name' => 'reject deal']);

    // create roles and assign existing permissions
    $role1 = Spatie\Permission\Models\Role::create(['name' => 'agent']);
    $role1->givePermissionTo('create deal');
    $role1->givePermissionTo('edit deal');
    $role1->givePermissionTo('delete deal');

    $role2 = Spatie\Permission\Models\Role::create(['name' => 'admin']);
    $role2->givePermissionTo('accept deal');
    $role2->givePermissionTo('reject deal');

    // create a demo user
    $user = Factory(App\User::class)->create([
        'name' => 'Example User',
        'email' => 'test@example.com',
        // factory default password is 'password'
    ]);
    $user->assignRole($role1);
    
    */
  }
}
