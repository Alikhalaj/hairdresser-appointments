<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'time' => $faker->numberBetween(1, 4) * 5,
        'name' => $faker->sentence(),
        'price' => $faker->numberBetween(1, 10) * 1000,
        'barber_id'=>function(){
            return factory(App\User::class)->create()->id;
        }
    ];
});
