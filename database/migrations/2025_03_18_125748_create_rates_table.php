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
        Schema::create('rates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->unsignedInteger('provider_id')->nullable();
            $table->integer('delegate_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->boolean('seen')->nullable()->default(false);
            $table->boolean('like')->nullable()->default(true);
            $table->boolean('rate')->nullable()->default(true);
            $table->double('delegate_rate', null, 0)->nullable()->default(5);
            $table->double('services_rate', null, 0)->nullable()->default(5);
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
