<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('play_id');
            $table->timestamp('date_time');
            $table->unsignedInteger('diverging_pricestructure_id')->nullable();
            $table->unsignedInteger('diverging_capacity_id')->nullable();
            $table->unsignedInteger('performance_type_id')->nullable();
            $table->string('additional_webpage_message',30)->default('');
            $table->string('remarks',50)->default('');

            $table->foreign('play_id')->references('id')->on('plays');
            $table->foreign('diverging_pricestructure_id')->references('id')->on('play_pricestructures');
            $table->foreign('diverging_capacity_id')->references('id')->on('play_capacities');
            $table->foreign('performance_type_id')->references('id')->on('performance_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
