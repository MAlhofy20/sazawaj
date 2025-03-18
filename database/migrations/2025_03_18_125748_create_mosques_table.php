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
        Schema::create('mosques', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('title_ar', 191)->nullable();
            $table->string('title_en', 191)->nullable();
            $table->string('lat', 191)->nullable();
            $table->string('lng', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->unsignedInteger('country_id')->index('mosques_country_id_foreign');
            $table->unsignedInteger('city_id')->index('mosques_city_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosques');
    }
};
