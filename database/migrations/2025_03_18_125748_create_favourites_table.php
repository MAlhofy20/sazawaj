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
        Schema::create('favourites', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('service_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('to_id')->nullable();
            $table->tinyInteger('seen')->nullable()->default(0);
            $table->timestamps();
            $table->tinyInteger('show_in_list')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
