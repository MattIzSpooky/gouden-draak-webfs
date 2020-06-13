<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DailySummary;
use Faker\Generator as Faker;

$factory->define(DailySummary::class, function (Faker $faker) {
    $date = $faker->unique()->date();
    return [
        'file' => 'summary-' . $date . '.xlsx',
        'date' => $date
    ];
});
