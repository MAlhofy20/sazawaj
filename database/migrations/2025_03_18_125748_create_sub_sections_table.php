<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar', 191)->nullable();
            $table->string('title_en', 191)->nullable();
            $table->longText('short_desc_ar')->nullable();
            $table->longText('short_desc_en')->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->string('image', 191)->nullable();
            $table->tinyInteger('show')->nullable()->default(1);
            $table->integer('main_section_id')->nullable();
            $table->integer('section_id')->nullable()->index('section_id');
            $table->unsignedInteger('user_id')->nullable()->index('sub_sections_ibfk_1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_sections');
    }
};
