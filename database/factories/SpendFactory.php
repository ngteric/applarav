<?php

use Faker\Generator as Faker;

$factory->define(App\Spend::class, function (Faker $faker) {
    static $password = 'root';
    $spendFaker = ['Voiture', 'Appart', 'Course', 'Extra', 'Vélo', 'Camping', 'Rando', 'Alcool', 'Clope'];
    return [
       'title' => $faker->unique()->randomElement($spendFaker),
       'description'=> $faker->text,
       'pay_date' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
       'price' => $faker->randomFloat(2, 0, 1000),
       'status' => 'paid'
    ];
});