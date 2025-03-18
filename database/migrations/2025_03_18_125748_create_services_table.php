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
        Schema::create('services', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('title_ar')->nullable();
            $table->text('title_en')->nullable();
            $table->longText('short_desc_ar')->nullable();
            $table->longText('short_desc_en')->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->string('type', 100)->nullable()->default('static');
            $table->double('amount', null, 0)->nullable()->default(0);
            $table->string('unit')->nullable();
            $table->double('rate', null, 0)->nullable()->default(0);
            $table->double('price', null, 0)->nullable();
            $table->double('price_with_value', null, 0)->nullable();
            $table->double('discount', null, 0)->nullable()->default(0);
            $table->double('value_added', null, 0)->nullable()->default(15);
            $table->double('calories', null, 0)->nullable()->default(0);
            $table->string('image', 191)->nullable();
            $table->integer('main_section_id')->nullable();
            $table->unsignedInteger('section_id')->nullable();
            $table->integer('sub_section_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('show')->nullable()->default(true);
            $table->boolean('is_fav')->nullable()->default(false);
            $table->boolean('best')->nullable()->default(false);
            $table->integer('sold')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
