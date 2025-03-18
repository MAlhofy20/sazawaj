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
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->nullable()->index('section_id');
            $table->double('value_added', null, 0)->nullable();
            $table->text('notes')->nullable();
            $table->double('count', null, 0)->nullable();
            $table->double('total', null, 0)->nullable();
            $table->integer('option_id')->nullable();
            $table->string('option_title')->nullable();
            $table->double('option_price', null, 0)->nullable();
            $table->string('service_title_en')->nullable();
            $table->longText('service_title_ar')->nullable();
            $table->integer('service_id')->nullable()->index('service_id');
            $table->unsignedInteger('order_id')->nullable()->index('order_items_order_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
