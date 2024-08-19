<?php

namespace Ajifatur\FaturHelper\Seeders\Dummy;

use Illuminate\Database\Seeder;
use Ajifatur\FaturHelper\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['code' => 'super-admin', 'name' => 'Super Admin', 'is_admin' => 1, 'is_global' => 1, 'num_order' => 1],
            ['code' => 'member', 'name' => 'Member', 'is_admin' => 0, 'is_global' => 0, 'num_order' => 2],
        ];

        foreach($roles as $role) {
            Role::firstOrCreate(
                ['code' => $role['code']],
                ['name' => $role['name'], 'is_admin' => $role['is_admin'], 'is_global' => $role['is_global'], 'num_order' => $role['num_order']]
            );
        }
    }
}
