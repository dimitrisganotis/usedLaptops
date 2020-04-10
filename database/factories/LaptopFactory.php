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
        'storage' => json_encode(["SSD1" => "250GB", "SSD2" => "128GB", "External HDD" => "1 TB"]),
        'os' => $faker->randomElement(['Windows', 'Linux', 'macOS', 'Chrome OS']),
        'damage' => $faker->boolean(30),
        'price' => $faker->numberBetween(1, 3000),
        'description' => $faker->text(),
    ];
});
