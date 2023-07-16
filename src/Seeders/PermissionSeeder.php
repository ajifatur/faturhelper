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
        // Add namespaces
        $array = Permission::where('code','not like','%Controllers%')->get();
        foreach($array as $key=>$data) {
            $permission = Permission::find($data->id);

            if($permission->default == 1)
                $permission->code = 'Ajifatur\\FaturHelper\\Http\\Controllers\\' . $permission->code;
            elseif($permission->default == 0)
                $permission->code = 'App\\Http\\Controllers\\' . $permission->code;

            $permission->save();
        }
        
        $array = [
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RoleController::index', 'name' => 'Mengelola Data Role'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RoleController::create', 'name' => 'Menambah Role'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RoleController::edit', 'name' => 'Mengubah Role'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RoleController::delete', 'name' => 'Menghapus Role'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RoleController::reorder', 'name' => 'Mengurutkan Role'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserController::index', 'name' => 'Mengelola Data Pengguna'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserController::create', 'name' => 'Menambah Pengguna'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserController::edit', 'name' => 'Mengubah Pengguna'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserController::delete', 'name' => 'Menghapus Pengguna'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserController::deleteBulk', 'name' => 'Menghapus Pengguna Terpilih'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserSettingController::index', 'name' => 'Menampilkan Profil'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserSettingController::profile', 'name' => 'Mengubah Profil'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserSettingController::account', 'name' => 'Mengubah Akun'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\UserSettingController::password', 'name' => 'Mengubah Password'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::index', 'name' => 'Mengelola Data Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::create', 'name' => 'Menambah Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::edit', 'name' => 'Mengubah Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::delete', 'name' => 'Menghapus Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::reorder', 'name' => 'Mengurutkan Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PermissionController::change', 'name' => 'Mengganti Status Hak Akses'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\SettingController::index', 'name' => 'Menampilkan Pengaturan'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\SettingController::image', 'name' => 'Menampilkan Pengaturan Gambar'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuController::index', 'name' => 'Mengelola Data Menu'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuHeaderController::create', 'name' => 'Menambah Menu Header'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuHeaderController::edit', 'name' => 'Mengubah Menu Header'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuHeaderController::delete', 'name' => 'Menghapus Menu Header'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuItemController::create', 'name' => 'Menambah Menu Item'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuItemController::edit', 'name' => 'Mengubah Menu Item'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MenuItemController::delete', 'name' => 'Menghapus Menu Item'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MetaController::index', 'name' => 'Mengelola Meta'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\MediaController::index', 'name' => 'Menampilkan Media'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::index', 'name' => 'Mengelola Data Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::create', 'name' => 'Menambah Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::edit', 'name' => 'Mengubah Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::delete', 'name' => 'Menghapus Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::reorder', 'name' => 'Mengurutkan Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\PeriodController::setting', 'name' => 'Pengaturan Periode'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\ScheduleController::index', 'name' => 'Mengelola Data Agenda'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\ScheduleController::update', 'name' => 'Mengupdate Agenda'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\ScheduleController::delete', 'name' => 'Menghapus Agenda'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\SystemController::index', 'name' => 'Menampilkan Lingkungan Sistem'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\DatabaseController::index', 'name' => 'Menampilkan Database'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\RouteController::index', 'name' => 'Menampilkan Route'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\ArtisanController::index', 'name' => 'Mengelola Perintah Artisan'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\StatsController::user', 'name' => 'Menampilkan Statistik Pengguna'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\StatsController::visitor', 'name' => 'Menampilkan Statistik Visitor'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\StatsController::visitorLocation', 'name' => 'Menampilkan Statistik Lokasi Visitor'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\LogController::activity', 'name' => 'Menampilkan Log Aktivitas'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\LogController::activityByURL', 'name' => 'Menampilkan Log Aktivitas Berdasarkan URL'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\LogController::authentication', 'name' => 'Menampilkan Log Autentikasi'],
            ['code' => 'Ajifatur\\FaturHelper\\Http\\Controllers\\VisitorController::index', 'name' => 'Menampilkan Data Visitor'],
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
