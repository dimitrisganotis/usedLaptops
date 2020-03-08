<?php

use Illuminate\Database\Seeder;

class LaptopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Laptop::class, 10)->create();
    }
}
