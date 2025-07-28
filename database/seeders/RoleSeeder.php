<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name' => 'customer']);

        // Create permissions
        $manageMenu = Permission::create(['name' => 'manage menu']);
        $manageReservations = Permission::create(['name' => 'manage reservations']);
        $placeOrders = Permission::create(['name' => 'place orders']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage menu', 'manage reservations']);
        $customer->givePermissionTo('place orders');
    }
}
