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
        Schema::create('strowallet_virtual_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string('name_on_card');
            $table->string('card_id');
            $table->string('card_created_date');
            $table->string('card_type');
            $table->string('card_brand');
            $table->string('card_user_id');
            $table->string('reference');
            $table->string('card_status');
            $table->string('customer_id');
            $table->string('card_name');
            $table->string('card_number');
            $table->string('last4');
            $table->string('cvv');
            $table->string('expiry');
            $table->string('customer_email');
            $table->string('balance');
            $table->boolean('status')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strowallet_virtual_cards');
    }
};





