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
        Schema::create('bank_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name', 191)->nullable();
            $table->string('account_name', 191)->nullable();
            $table->string('account_number', 191)->nullable();
            $table->string('amount', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->integer('order_id')->nullable();
            $table->unsignedInteger('user_id')->nullable()->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transfers');
    }
};
