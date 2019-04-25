<?php

use Faker\Generator as Faker;

require 'fakevars.php';

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement($fakevars('plays'))
    ];
});
