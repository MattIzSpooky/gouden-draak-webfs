<?php

use App\Order;
use App\Table;
use App\MenuItem;
use Carbon\Carbon;
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
        factory(Order::class, 10)->create(['created_at' => Carbon::now()->addYears(-1)])->each(function (Order $order) {
            for ($i = 0; $i < 3; $i++) {
                $item = MenuItem::all()->random(1)->first();
                $order->items()->attach($item->id, ['amount' => rand(1, 5)]);
                $order->tables()->attach(Table::find(1));
            }
        });

        factory(Order::class, 10)->create()->each(function (Order $order) {
            for ($i = 0; $i < 3; $i++) {
                $item = MenuItem::all()->random(1)->first();
                $order->items()->attach($item->id, ['amount' => rand(1, 5)]);
                $order->tables()->attach(Table::find(1));
            }
        });
    }
}
