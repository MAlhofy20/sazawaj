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
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('show_user_id')->default(1);
            $table->unsignedInteger('saler_id')->nullable();
            $table->integer('show_saler_id')->default(1);
            $table->integer('order_id')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('show_ids', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
