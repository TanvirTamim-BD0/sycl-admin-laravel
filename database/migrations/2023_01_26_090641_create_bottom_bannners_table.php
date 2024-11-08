<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottomBannnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottom_bannners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('banner_category_id')->nullable();
            $table->string('bottom_banner_image')->nullable();
            $table->string('bottom_banner_text_1')->nullable();
            $table->string('bottom_banner_text_2')->nullable();
            $table->string('bottom_banner_text_3')->nullable();
            $table->foreign('banner_category_id')->references('id')->on('banner_categories')->onDelete('cascade');
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
        Schema::dropIfExists('bottom_bannners');
    }
}
