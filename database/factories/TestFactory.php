<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Test::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'category_id' => rand(1,4),
        'difficulty' => $faker->randomElement(['1','2','3','4','5']),
        'max_time' => $faker->randomElement([10,15,20,25,30]),
        'questions' => $faker->randomDigit,
        'created_by' => $faker->randomDigit
    ];
});
