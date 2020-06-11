<?php

namespace App;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Table;
use Faker\Generator as Faker;

$factory->define(Table::class, function (Faker $faker) {
    return [
        'name' => 'Tafel-' . $faker->unique()->randomNumber(3),
    ];
});
