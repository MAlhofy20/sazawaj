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
        Schema::create('sections', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('short_desc_ar')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->string('image')->nullable();
            $table->string('type', 100)->nullable()->default('saler');
            $table->boolean('show')->nullable()->default(true);
            $table->tinyInteger('show_data')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
