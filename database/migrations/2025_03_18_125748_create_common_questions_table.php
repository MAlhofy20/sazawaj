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
        Schema::create('common_questions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->mediumText('title_ar')->nullable();
            $table->mediumText('title_en')->nullable();
            $table->mediumText('desc_ar')->nullable();
            $table->text('type');
            $table->mediumText('desc_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_questions');
    }
};
