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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('header')->nullable();
            $table->string('message_ar', 191)->nullable();
            $table->string('message_en', 191)->nullable();
            $table->boolean('seen')->nullable();
            $table->string('url')->nullable();
            $table->string('type', 191)->nullable();
            $table->integer('order_id')->nullable();
            $table->string('order_status', 191)->nullable();
            $table->unsignedInteger('to_id')->nullable()->index('notifications_to_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
