<?php

use App\DishType;
use Illuminate\Database\Seeder;

class DishTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Soep', 'Voorgerecht', 'Bami en nasi gerechten', 'Combinatie Gerechten (met witte rijst)'];

        foreach ($types as $type) {
            DishType::create(['type' => $type]);
        }
    }
}
