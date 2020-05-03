<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laptop;
use Faker\Generator as Faker;

$factory->define(Laptop::class, function (Faker $faker) {
    return [
        'user_id' => 1,//$faker->numberBetween(1, 5),
        'brand' => $faker->name,
        'model' => $faker->name,
        'year' => $faker->year,
        'cpuBrand' => $faker->randomElement(['Intel', 'AMD', 'Other']),
        'cpuModel' => $faker->name,
        'cpuCores' => $faker->numberBetween(1, 32),
        'cpuFrequency' => $faker->randomFloat(3, 1, 5),
        'ramSize' => $faker->numberBetween(1, 64),
        'storage1' => ["type" => "hdd", "size" => "1", "unit" => "TB"],
        'storage2' => ["type" => "ssd", "size" => "250", "unit" => "GB"],
        'os' => $faker->randomElement(['Windows', 'Linux', 'macOS', 'Chrome OS']),
        'damage' => $faker->boolean(30),
        'price' => $faker->numberBetween(1, 3000),
        'description' => $faker->text(),
    ];
});
