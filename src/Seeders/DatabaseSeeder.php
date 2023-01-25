<?php

namespace Ajifatur\FaturHelper\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MetaSeeder::class);
        $this->call(PeriodSeeder::class);
    }
}
