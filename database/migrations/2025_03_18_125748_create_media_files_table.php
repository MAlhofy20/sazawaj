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
        Schema::create('media_files', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('short_desc_ar')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->date('date')->nullable();
            $table->double('lat', null, 0)->nullable();
            $table->double('lng', null, 0)->nullable();
            $table->bigInteger('seen')->nullable()->default(0);
            $table->integer('section_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
