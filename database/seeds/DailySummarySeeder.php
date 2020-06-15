<?php

use App\DailySummary;
use Illuminate\Database\Seeder;

class DailySummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DailySummary::class)->create();
    }
}
