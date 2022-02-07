<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Barber;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Barber::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image($faker->image());
    $file2 = UploadedFile::fake()->image($faker->image());
    return [
        'name_shop'=>$faker->name(),
        'phone' =>$faker->phoneNumber(),
        'address'=>$faker->address(),
        'time_work_start'=>Carbon::now('Asia/Tehran')->format('H:i:s'),
        'time_work_end'=> Carbon::now('Asia/Tehran')->subHours(8)->format('H:i:s'),
        'image_business_license'=>$file,
        'image_hairdressing_degree'=>$file2,
        'latitude'=>$faker->latitude(25,39),
        'longitude'=>$faker->longitude(44,63),
        'suggest'=>'0',
        'offer'=>'0',
        'user_id'=>factory(App\User::class)->create()->id
        
    ];
});
