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
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar', 191)->nullable();
            $table->string('title_en', 191)->nullable();
            $table->unsignedInteger('country_id')->nullable()->index('neighborhoods_country_id_foreign');
            $table->unsignedInteger('city_id')->nullable()->index('neighborhoods_city_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neighborhoods');
    }
};
