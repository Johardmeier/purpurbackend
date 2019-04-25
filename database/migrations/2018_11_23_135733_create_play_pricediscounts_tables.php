<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayPricediscountsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_pricediscounts_junior', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('pricestructure_id');
            $table->string('name');
            $table->decimal('price',4,2);
            $table->string('remarks')->default('');

            $table->foreign('pricestructure_id')->references('id')->on('play_pricestructures');
        });

        Schema::create('play_pricediscounts_adult', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('pricestructure_id');
            $table->string('name');
            $table->decimal('price',4,2);
            $table->string('remarks')->default('');

            $table->foreign('pricestructure_id')->references('id')->on('play_pricestructures');

        });

        Schema::create('play_pricediscounts_group', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('pricestructure_id');
            $table->string('name');
            $table->string('formula');
            $table->string('remarks')->default('');

            $table->foreign('pricestructure_id')->references('id')->on('play_pricestructures');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('play_pricediscounts_adult');
        Schema::dropIfExists('play_pricediscounts_junior');
        Schema::dropIfExists('play_pricediscounts_group');

    }
}
