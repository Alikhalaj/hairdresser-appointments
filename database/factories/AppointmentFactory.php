<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\Barber;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    $start = Carbon::create($this->faker->dateTimeBetween(now(), '+1 week', 'Asia/Tehran'));
    $end = Carbon::create($start)->addMinutes(20);
    return [
        'user_id' => User::all()->random()->id,
        'barber_id' => Barber::all()->random()->id,
        'time_start'=>$start,
        'time_end' =>$end,
        'price' => $this->faker->numberBetween(1, 10) * 1000,
        'prepayment' => $this->faker->numberBetween(1, 3) * 1000
    ];
});
