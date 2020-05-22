<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use App\MenuItem;
use App\MenuAddition;
use Faker\Generator as Faker;

$factory->define(MenuItem::class, function (Faker $faker) {
    return [
        'menu_number' => $faker->unique()->numberBetween(1, 100),
        'addition' => 'A',
    ];
});
