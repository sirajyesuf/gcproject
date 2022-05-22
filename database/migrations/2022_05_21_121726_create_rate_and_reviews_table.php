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
        Schema::create('rate_and_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('rate');
            $table->string('review');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_provider_id');
            
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('service_provider_id')->on('service_providers')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_and_reviews');
    }
};
