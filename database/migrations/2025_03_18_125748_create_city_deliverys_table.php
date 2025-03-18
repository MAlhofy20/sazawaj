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
        Schema::create('city_deliverys', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('city_id')->nullable();
            $table->integer('city_to_id')->nullable();
            $table->double('price', null, 0)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_deliverys');
    }
};
