<?php

use Faker\Generator as Faker;

$factory->define(App\Team::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'logo_url'=>$faker->imageUrl(100,100)
    ];
    //'logo_url'=>$faker->image('storage/app/public/uploads/', 300, 300, 'city', false, true, 'Faker')
});


