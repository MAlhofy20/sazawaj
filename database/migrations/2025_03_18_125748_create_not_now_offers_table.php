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
        Schema::create('not_now_offers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('saler_id')->nullable();
            $table->double('amount', null, 0)->nullable()->default(0);
            $table->double('total', null, 0)->nullable()->default(0);
            $table->string('duration')->nullable();
            $table->double('current_amount', null, 0)->nullable()->default(0);
            $table->double('current_total', null, 0)->nullable()->default(0);
            $table->double('current_debt', null, 0)->nullable()->default(0);
            $table->tinyInteger('delete')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('not_now_offers');
    }
};
