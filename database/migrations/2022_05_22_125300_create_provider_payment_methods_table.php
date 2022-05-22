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
        Schema::create('provider_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('payment_method');
            $table->string('account_number');
            $table->string('account_holder');
            $table->unsignedBigInteger('service_provider_id');

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
        Schema::dropIfExists('provider_payment_methods');
    }
};
