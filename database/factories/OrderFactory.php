<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'paid_at' => $faker->boolean() ?
            Carbon::parse($faker->dateTimeBetween('-1 years')) : null,
    ];
});
