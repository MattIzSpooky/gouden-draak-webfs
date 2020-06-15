<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DailySummary;
use Faker\Generator as Faker;

$factory->define(DailySummary::class, function (Faker $faker) {
    return [
        'file' => 'summary-2020-06-15.xlsx',
        'date' => '2020-06-15'
    ];
});
