<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaptopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('brand', 30);
            $table->string('model', 120);
            $table->year('year')->nullable();
            $table->enum('cpuBrand', ['Intel', 'AMD', 'Other']);
            $table->string('cpuModel', 30)->nullable();
            $table->tinyInteger('cpuCores')->nullable();
            $table->decimal('cpuFrequency', 3, 2)->nullable();
            $table->tinyInteger('ramSize');
            $table->string('storage')->nullable(); // Json
            $table->set('os', ['Windows', 'Linux', 'macOS', 'Chrome OS']);
            $table->boolean('damage');
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->unsignedMediumInteger('views')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laptops');
    }
}
