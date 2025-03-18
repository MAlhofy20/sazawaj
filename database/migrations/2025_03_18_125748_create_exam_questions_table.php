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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('exam_id')->nullable();
            $table->mediumText('question_ar')->nullable();
            $table->mediumText('question_en')->nullable();
            $table->mediumText('first_answer_ar')->nullable();
            $table->mediumText('first_answer_en')->nullable();
            $table->mediumText('second_answer_ar')->nullable();
            $table->mediumText('second_answer_en')->nullable();
            $table->mediumText('third_answer_ar')->nullable();
            $table->mediumText('third_answer_en')->nullable();
            $table->mediumText('fourth_answer_ar')->nullable();
            $table->mediumText('fourth_answer_en')->nullable();
            $table->mediumText('answer')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
