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
        Schema::create('carts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('user_id')->nullable()->index('user_id');
            $table->unsignedInteger('provider_id')->nullable()->index('provider_id');
            $table->unsignedInteger('section_id')->nullable()->index('section_id');
            $table->integer('service_id')->nullable()->index('service_id');
            $table->integer('size_id')->nullable();
            $table->integer('option_id')->nullable();
            $table->string('size_title')->nullable();
            $table->double('size_price', null, 0)->nullable();
            $table->string('option_title')->nullable();
            $table->double('option_price', null, 0)->nullable();
            $table->integer('side_id')->nullable();
            $table->string('side_title')->nullable();
            $table->double('side_price', null, 0)->nullable();
            $table->double('count', null, 0)->nullable()->default(0);
            $table->double('total', null, 0)->nullable()->default(0);
            $table->double('sub_total', null, 0)->nullable()->default(0);
            $table->double('delivery', null, 0)->nullable();
            $table->double('delivery_time', null, 0)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
