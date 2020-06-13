<?php

use App\MenuAddition;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(DishTypeSeeder::class);
        $this->call(MenuAdditionSeeder::class);
        Artisan::call('menu:seed');
        $this->call(TableSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(PromotionalDiscountsSeeder::class);
        $this->call(DailySummarySeeder::class);
    }
}
