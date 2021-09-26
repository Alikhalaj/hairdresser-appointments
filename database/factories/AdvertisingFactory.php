<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Advertising;
use Faker\Generator as Faker;

$factory->define(Advertising::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'image_address'=>$faker->image()
    ];
});
