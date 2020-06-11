<?php

use App\Dish;
use App\MenuItem;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dish::class, 10)->create()->each(function (Dish $dish) {
            $item = factory(MenuItem::class)
                ->make(['dish_id' => $dish->id])->save();
        });
    }
}
