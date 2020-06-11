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
        foreach (range('A', 'Z') as $char) {
            MenuAddition::create(['character' => $char]);
        }

        foreach (['M', 'P', 'T', 'V', 'K', 'R'] as $char) {
            for ($i = 1; $i < 7; $i++) {
                MenuAddition::create(['character' => $char . $i]);
            }
        }
    }
}
