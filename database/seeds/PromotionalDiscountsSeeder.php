<?php

use App\Dish;
use App\Order;
use App\PromotionalDiscounts;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PromotionalDiscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PromotionalDiscounts::class, 4)->create()->each(function (PromotionalDiscounts $discount) {
            /** @var Collection */
            $orders = Dish::all()->random(3)->pluck('id');
            foreach ($orders as $order) {
                $discount->dishes()->attach($order);
            }
        });
    }
}
