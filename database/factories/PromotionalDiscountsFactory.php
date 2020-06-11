<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\PromotionalDiscounts;
use Faker\Generator as Faker;

$factory->define(PromotionalDiscounts::class, function (Faker $faker) {
    $date = $faker->unique()->dateTimeBetween('-10 days', '+15 days');
    return [
        'title' => ucfirst($faker->word()),
        'text' => $faker->text(100),
        'valid_from' => $date,
        'valid_till' => Carbon::parse($date)->addDays(5),
        'price' => $faker->randomFloat(2, 1, 100)
    ];
});
