<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laptop;
use Faker\Generator as Faker;

$factory->define(Laptop::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 5),
        'brand' => $faker->company,
        'model' => $faker->name,
        'year' => $faker->year,
        'cpuBrand' => $faker->randomElement(['Intel', 'AMD', 'Other']),
        'cpuModel' => $faker->name,
        'cpuCores' => $faker->numberBetween(1, 128),
        'cpuFrequency' => $faker->randomFloat(3, 1, 5),
        'ramSize' => $faker->numberBetween(1, 128),
        'storage' => json_encode(["SSD" => 250, "SSD" => 128, "External HDD" => 500]),
        'os' => $faker->randomElement(['Windows', 'Linux', 'macOS', 'Chrome OS']),
        'damage' => $faker->boolean(30),
        'price' => $faker->numberBetween(1, 3000),
        'description' => $faker->text(),
    ];
});
