<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('gender')->nullable(); //male , female
            $table->longText('notes')->nullable();
            $table->string('section_title_ar')->nullable();
            $table->string('section_title_en')->nullable();
            $table->string('section_price')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('time')->nullable();
            $table->string('amount')->nullable();
            $table->string('value_added')->nullable();
            $table->string('delivery')->nullable();
            $table->string('total_before_promo')->nullable();
            $table->string('total_after_promo')->nullable();
            $table->string('duration')->nullable(); //once , urban , annual
            $table->string('payment_method')->nullable(); //cash , bank_transfer , online
            $table->string('status')->nullable(); //new , agree , refused , in_way , finish

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections');
            // $table->integer('country_id')->unsigned();
            // $table->foreign('country_id')->references('id')->on('countries');
            // $table->integer('city_id')->unsigned();
            // $table->foreign('city_id')->references('id')->on('cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
