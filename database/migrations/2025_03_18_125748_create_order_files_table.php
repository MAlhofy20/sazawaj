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
        Schema::create('order_files', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('report_number', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->date('dob')->nullable();
            $table->string('right', 100)->nullable();
            $table->string('right_w', 100)->nullable();
            $table->string('left', 100)->nullable();
            $table->string('left_w', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('blood_type', 100)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('seha')->nullable()->default(false);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_files');
    }
};
