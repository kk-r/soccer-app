<?php

use Faker\Generator as Faker;

$factory->define(App\Player::class, function (Faker $faker) {
    $team_ids = \DB::table('teams')->select('id')->get()->toArray();
    $team_id = (!empty($team_ids) ? $faker->randomElement($team_ids)->id : null);
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'logo_url' => $faker->imageUrl(100, 100),
        'team_id' => $team_id
    ];
    // 'logo_url'=>$faker->image('storage/app/public/uploads/', 300, 300, 'people', false, true, 'Faker'),
});
