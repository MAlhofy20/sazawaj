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
        Schema::create('order_providers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('status', 100)->nullable()->default('new');
            $table->double('delivery', null, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_providers');
    }
};
