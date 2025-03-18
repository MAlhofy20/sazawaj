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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('data_upload')->nullable()->default(0);
            $table->integer('order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('type')->nullable();
            $table->string('user_name', 191)->nullable();
            $table->string('user_phone', 191)->nullable();
            $table->string('provider_name')->nullable();
            $table->string('provider_phone')->nullable();
            $table->double('provider_lat', null, 0)->nullable();
            $table->double('provider_lng', null, 0)->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('id_code')->nullable();
            $table->string('id_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email')->nullable();
            $table->string('file')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('neighborhood_id')->nullable();
            $table->string('shipping_type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->string('city_title_ar')->nullable();
            $table->string('city_title_en')->nullable();
            $table->string('neighborhood_title_ar')->nullable();
            $table->string('neighborhood_title_en')->nullable();
            $table->string('image')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('is_delivery')->nullable()->default(true);
            $table->string('lat', 191)->nullable();
            $table->string('lng', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->double('user_distance', null, 0)->nullable()->default(0);
            $table->date('date')->nullable();
            $table->string('time', 191)->nullable();
            $table->boolean('confirm')->nullable()->default(true);
            $table->string('amount', 191)->nullable();
            $table->double('sub_total', null, 0)->nullable();
            $table->string('value_added', 191)->nullable();
            $table->string('delivery', 191)->nullable();
            $table->string('total_before_promo', 191)->nullable();
            $table->string('total_after_promo', 191)->nullable();
            $table->double('provider_profit', null, 0)->nullable();
            $table->double('delgate_profit', null, 0)->nullable();
            $table->double('provider_debt', null, 0)->nullable()->default(0);
            $table->double('delgate_debt', null, 0)->nullable()->default(0);
            $table->double('commission_total', null, 0)->nullable()->default(0);
            $table->string('duration', 191)->nullable();
            $table->string('payment_method', 191)->nullable();
            $table->string('booking_method', 100)->nullable()->default('now');
            $table->date('booking_later_date')->nullable();
            $table->time('booking_later_time')->nullable();
            $table->boolean('is_paid')->nullable()->default(true);
            $table->string('status', 191)->nullable();
            $table->date('status_date')->nullable();
            $table->string('status_user_name')->nullable();
            $table->tinyInteger('is_rated')->nullable()->default(0);
            $table->string('rate', 50)->nullable();
            $table->text('desc')->nullable();
            $table->text('cancel_notes')->nullable();
            $table->string('api_token')->nullable();
            $table->tinyInteger('admin_check')->nullable()->default(0);
            $table->string('promo_code')->nullable();
            $table->unsignedInteger('promo_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->unsignedInteger('user_id')->nullable()->index('orders_user_id_foreign');
            $table->unsignedInteger('provider_id')->nullable()->index('provider_id');
            $table->unsignedInteger('delegate_id')->nullable()->index('delegate_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
