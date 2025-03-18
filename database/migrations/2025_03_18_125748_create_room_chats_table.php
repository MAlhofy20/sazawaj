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
        Schema::create('room_chats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('from_id')->nullable()->index('from_id');
            $table->unsignedInteger('to_id')->nullable()->index('to_id');
            $table->integer('room_id')->nullable()->index('room_id');
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->string('type', 100)->nullable()->default('text');
            $table->string('show_ids', 100)->nullable();
            $table->boolean('seen')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_chats');
    }
};
