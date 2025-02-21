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
        Schema::create('referral_level_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title',250)->unique()->nullable();
            $table->string('refer_user');
            $table->decimal('deposit_amount',28,8);
            $table->decimal('commission',28,8);
            $table->boolean('default')->default(false);
            $table->timestamps();
        });
    }

    /**\
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_level_packages');
    }
};
