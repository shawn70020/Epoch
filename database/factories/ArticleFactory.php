<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(30),
        'body' => $faker->text(200),
    ];
});
