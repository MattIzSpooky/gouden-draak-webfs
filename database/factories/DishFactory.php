<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use App\DishType;
use Faker\Generator as Faker;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text(100),
        'price' => $faker->randomFloat(2, 1, 100),
        'dish_type_id' => DishType::all()->random(1)->pluck('id')->first()
    ];
});
