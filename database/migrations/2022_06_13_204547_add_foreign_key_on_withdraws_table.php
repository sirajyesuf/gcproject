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
<<<<<<< HEAD:database/migrations/2022_06_13_151335_create_notifications_table.php
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tittle');
            $table->longText('description');
            $table->boolean('is_read');
            $table->timestamps();
=======
        Schema::table('withdraws', function (Blueprint $table) {
            $table->foreign('service_provider_id')->on('service_providers')->references('id');
>>>>>>> siraj:database/migrations/2022_06_13_204547_add_foreign_key_on_withdraws_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<< HEAD:database/migrations/2022_06_13_151335_create_notifications_table.php
        Schema::dropIfExists('notifications');
=======
        Schema::table('withdraws', function (Blueprint $table) {
            //
        });
>>>>>>> siraj:database/migrations/2022_06_13_204547_add_foreign_key_on_withdraws_table.php
    }
};
