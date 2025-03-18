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
        Schema::create('service_sides', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->double('price', null, 0)->nullable();
            $table->double('price_with_value', null, 0)->nullable();
            $table->string('type')->nullable();
            $table->integer('service_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_sides');
    }
};
