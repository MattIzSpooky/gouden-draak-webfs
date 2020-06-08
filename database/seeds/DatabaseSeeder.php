<?php

use App\MenuAddition;
use App\User;
use Illuminate\Database\Seeder;

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
        $this->call(DishSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(PromotionalDiscountsSeeder::class);
    }
}
