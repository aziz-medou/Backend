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
        Schema::create('referred_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refer_user_id')->comment("Who own the refer or parent");
            $table->unsignedBigInteger('new_user_id')->comment("who use a referral id when registering");
            $table->timestamps();

            $table->foreign('new_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('refer_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referred_users');
    }
};
