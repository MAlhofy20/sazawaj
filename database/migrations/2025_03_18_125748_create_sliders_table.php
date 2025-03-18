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
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 191)->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('image', 191)->nullable();
            $table->string('type', 100)->nullable()->default('app');
            $table->string('sub_type', 100)->nullable()->default('home');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
