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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar', 191)->nullable();
            $table->string('title_en', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('account_name', 191)->nullable();
            $table->string('account_number', 191)->nullable();
            $table->string('iban_number', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
