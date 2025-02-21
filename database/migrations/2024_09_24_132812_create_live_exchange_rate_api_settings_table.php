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
        Schema::create('live_exchange_rate_api_settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug',100);
            $table->string('provider',100);
            $table->text('value')->nullable();
            $table->decimal('multiply_by', 28, 8)->default(0);
            $table->boolean('currency_module')->default(true);
            $table->boolean('payment_gateway_module')->default(true);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('live_exchange_rate_api_settings');
    }
};
