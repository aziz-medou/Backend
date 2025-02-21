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
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->boolean('sms_notification')->default(false)->after('email_notification');
            $table->string('sms_api')->nullable()->after('sms_config');

            $table->boolean('agent_sms_verification')->default(false);
            $table->boolean('agent_sms_notification')->default(false);

            $table->boolean('merchant_sms_verification')->default(false);
            $table->boolean('merchant_sms_notification')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
