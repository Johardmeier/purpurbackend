<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true);
            $table->string('name',50);
            $table->string('forename',50)->default('');
            $table->string('address',40)->default('');
            $table->string('city',30)->default('');
            $table->string('area_code',8)->default('');
            $table->string('email',50)->default('');;
            $table->string('phone',15)->default('');;;
            $table->string('mobile',15)->default('');;;
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('remarks',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
