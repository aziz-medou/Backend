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
        Schema::create('frontend_header_sections', function (Blueprint $table) {
            $table->id();
            $table->enum("type",[
                GlobalConst::PERSONAL,
                GlobalConst::BUSINESS,
                GlobalConst::ENTERPRISE,
                GlobalConst::COMPANY,
            ]);
            $table->string("slug")->nullable()->unique();
            $table->text("icon")->nullable();
            $table->text("title")->nullable();
            $table->longText("sub_title")->nullable();
            $table->unsignedBigInteger("last_edit_by")->nullable();
            $table->boolean("status")->default(true);

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
        Schema::dropIfExists('froentend_header_sections');
    }
};
