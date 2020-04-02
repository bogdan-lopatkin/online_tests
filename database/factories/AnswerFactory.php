<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Answer::class, function (Faker $faker) {
    return [
        'question_id' => rand(1,10),
        'answer_body' => $faker->text(),
        'is_correct' => 0
    ];
});
