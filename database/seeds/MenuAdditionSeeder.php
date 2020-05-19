<?php

use App\MenuAddition;
use Illuminate\Database\Seeder;

class MenuAdditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c = 'A'; $c < 'Z'; $c++) {
            MenuAddition::create(['character' => $c]);
        }
    }
}
