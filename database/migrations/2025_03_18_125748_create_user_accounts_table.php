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
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->double('total', null, 0)->nullable();
            $table->double('admin_benfit', null, 0)->nullable();
            $table->double('user_benfit', null, 0)->nullable();
            $table->double('admin_recived', null, 0)->nullable();
            $table->double('user_recived', null, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accounts');
    }
};
