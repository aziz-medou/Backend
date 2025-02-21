<?php

use App\Constants\GlobalConst;
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
        Schema::create('frontend_header_section_faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->enum("type",[
                GlobalConst::PERSONAL,
                GlobalConst::BUSINESS,
                GlobalConst::ENTERPRISE,
                GlobalConst::COMPANY,
            ]);
            $table->longText('value')->nullable();
            $table->unsignedBigInteger("last_edit_by")->nullable();
            $table->boolean("status")->default(true);

            $table->foreign("parent_id")->references("id")->on("frontend_header_sections")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("last_edit_by")->references("id")->on("admins")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('frontend_header_section_faqs');
    }
};
