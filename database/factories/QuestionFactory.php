<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Question::class, function (Faker $faker) {
    return [
        'test_id' => rand(0,100),
        'points' => rand(0,10),
        'turn' => rand(0,10),
        'question_body' => $faker->text
    ];
});
