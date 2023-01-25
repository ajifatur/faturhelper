<?php

namespace Ajifatur\FaturHelper\Seeders;

use Illuminate\Database\Seeder;
use Ajifatur\FaturHelper\Models\Period;

class PeriodSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $periods = [
            ['name' => '2022', 'status' => 0, 'num_order' => 1],
            ['name' => '2023', 'status' => 1, 'num_order' => 2],
        ];

        foreach($periods as $period) {
            Period::firstOrCreate(
                ['status' => $period['status']],
                ['name' => $period['name'], 'num_order' => $period['num_order']]
            );
        }
    }
}
