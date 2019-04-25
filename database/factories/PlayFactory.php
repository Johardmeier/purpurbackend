<?php

$this->app->singleton(\Faker\Generator::class, function () {
    $faker=\Faker\Factory::create('de_CH');
    $faker->addProvider(new PlayFaker($faker));
    return $faker;
});

$factory->define(App\Play::class, function (\Faker\Generator $faker) {
    return [
        'title'=> $faker->playTitle,
    ];
});
