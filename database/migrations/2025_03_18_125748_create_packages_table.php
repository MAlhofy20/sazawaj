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
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->double('amount', null, 0)->nullable();
            $table->double('price', null, 0)->nullable();
            $table->double('price_with_value', null, 0)->nullable();
            $table->string('coach_name')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->integer('user_id')->nullable();
            $table->string('type')->nullable()->default('package');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
