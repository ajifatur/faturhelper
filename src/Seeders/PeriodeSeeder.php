<?php

namespace Ajifatur\FaturHelper\Seeders;

use Illuminate\Database\Seeder;
use Ajifatur\FaturHelper\Models\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $periodes = [
            ['name' => '2022', 'status' => '0', 'num_order' => 1],
            ['name' => '2023', 'status' => '1', 'num_order' => 2],
        ];

        foreach($periodes as $periode) {
            Periode::firstOrCreate(
                ['status' => $periode['status']],
                ['name' => $periode['name'], 'num_order' => $periode['num_order']]
            );
        }
    }
}
