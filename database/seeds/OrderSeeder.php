<?php

use App\MenuItem;
use App\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 10)->create()->each(function (Order $order) {
            for ($i = 0; $i < 3; $i++) {
                $item = MenuItem::all()->random(1)->first();
                $order->items()->attach($item->id, ['amount' => rand(1, 5)]);
            }
        });
    }
}
