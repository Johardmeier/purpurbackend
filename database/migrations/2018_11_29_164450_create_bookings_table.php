<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('performance_id');
            $table->unsignedInteger('booking_means_id');
            $table->unsignedInteger('booking_agent_id');
            $table->string('remarks',50)->nullable();
            $table->boolean('processed');  //probably not necessary... processed=all

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->foreign('booking_means_id')->references('id')->on('lu_bookingmeans');
            $table->foreign('booking_agent_id')->references('id')->on('booking_agents');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
