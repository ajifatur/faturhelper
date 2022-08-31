<?php

namespace Ajifatur\FaturHelper\Seeders;

use Illuminate\Database\Seeder;
use Ajifatur\FaturHelper\Models\Permission;
use Ajifatur\FaturHelper\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['code' => 'RoleController::index', 'name' => 'Mengelola Data Role'],
            ['code' => 'RoleController::create', 'name' => 'Menambah Role'],
            ['code' => 'RoleController::edit', 'name' => 'Mengubah Role'],
            ['code' => 'RoleController::delete', 'name' => 'Menghapus Role'],
            ['code' => 'RoleController::reorder', 'name' => 'Mengurutkan Role'],
            ['code' => 'UserController::index', 'name' => 'Mengelola Data Pengguna'],
            ['code' => 'UserController::create', 'name' => 'Menambah Pengguna'],
            ['code' => 'UserController::edit', 'name' => 'Mengubah Pengguna'],
            ['code' => 'UserController::delete', 'name' => 'Menghapus Pengguna'],
            ['code' => 'UserController::deleteBulk', 'name' => 'Menghapus Pengguna Terpilih'],
            ['code' => 'PermissionController::index', 'name' => 'Mengelola Data Hak Akses'],
            ['code' => 'PermissionController::create', 'name' => 'Menambah Hak Akses'],
            ['code' => 'PermissionController::edit', 'name' => 'Mengubah Hak Akses'],
            ['code' => 'PermissionController::delete', 'name' => 'Menghapus Hak Akses'],
            ['code' => 'PermissionController::reorder', 'name' => 'Mengurutkan Hak Akses'],
            ['code' => 'PermissionController::change', 'name' => 'Mengganti Status Hak Akses'],
            ['code' => 'MenuController::index', 'name' => 'Mengelola Data Menu'],
            ['code' => 'MenuHeaderController::create', 'name' => 'Menambah Menu Header'],
            ['code' => 'MenuHeaderController::edit', 'name' => 'Mengubah Menu Header'],
            ['code' => 'MenuHeaderController::delete', 'name' => 'Menghapus Menu Header'],
            ['code' => 'MenuItemController::create', 'name' => 'Menambah Menu Item'],
            ['code' => 'MenuItemController::edit', 'name' => 'Mengubah Menu Item'],
            ['code' => 'MenuItemController::delete', 'name' => 'Menghapus Menu Item'],
            ['code' => 'MetaController::index', 'name' => 'Mengelola Meta'],
            ['code' => 'SystemController::index', 'name' => 'Menampilkan Lingkungan Sistem'],
            ['code' => 'DatabaseController::index', 'name' => 'Menampilkan Database'],
            ['code' => 'RouteController::index', 'name' => 'Menampilkan Route'],
            ['code' => 'ArtisanController::index', 'name' => 'Mengelola Perintah Artisan'],
            ['code' => 'LogController::activity', 'name' => 'Menampilkan Log Aktivitas'],
            ['code' => 'LogController::activityByURL', 'name' => 'Menampilkan Log Aktivitas Berdasarkan URL'],
            ['code' => 'LogController::authentication', 'name' => 'Menampilkan Log Autentikasi'],
            ['code' => 'VisitorController::index', 'name' => 'Menampilkan Data Visitor'],
        ];

        $role = Role::where('code', '=', 'super-admin')->first();

        foreach($array as $key=>$data) {
            $permission = Permission::updateOrCreate(
                ['code' => $data['code']],
                ['name' => $data['name'], 'default' => 1, 'num_order' => ($key+1)]
            );

            if($role) {
                if(!in_array($role->id, $permission->roles()->pluck('id')->toArray())) {
                    $permission->roles()->attach($role->id);
                }
            }
        }
    }
}
