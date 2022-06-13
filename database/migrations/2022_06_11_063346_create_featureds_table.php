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
        Schema::create('featureds', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('title');
            $table->string('description');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('service_provider_id');
            $table->timestamps();
            $table->foreign('service_provider_id')->on('service_providers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featureds');
    }
};
