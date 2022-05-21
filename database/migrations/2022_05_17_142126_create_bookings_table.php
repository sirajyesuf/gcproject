<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('service_provider_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger("status");// 1,booked, 2, done
            $table->date('service_date');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('service_provider_id')->references('id')->on('service_providers');
            $table->foreign('user_id')->references('id')->on('users');

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
};
