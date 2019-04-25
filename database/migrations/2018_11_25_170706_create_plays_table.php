<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('production_infos')->default('');
            $table->integer('min_age')->nullable();
            $table->integer('duration')->nullable();
            $table->unsignedInteger('artist_id')->nullable();
            $table->unsignedInteger('pricestructure_id')->nullable();
            $table->unsignedInteger('capacity_id')->nullable();
            $table->unsignedInteger('language_id')->nullable();
            $table->string('additional_webpage_message',30)->default('');
            $table->string('remarks',50)->nullable();

            $table->foreign('artist_id')->references('id')->on('artists');
            $table->foreign('pricestructure_id')->references('id')->on('play_pricestructures');
            $table->foreign('capacity_id')->references('id')->on('play_capacities');
            $table->foreign('language_id')->references('id')->on('lu_languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plays');
    }
}
