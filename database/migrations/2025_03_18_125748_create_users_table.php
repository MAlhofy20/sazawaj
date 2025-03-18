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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->nullable();
            $table->string('username')->nullable();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('phone_code')->nullable()->default('966');
            $table->string('phone', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('code', 191)->nullable();
            $table->string('user_type', 191)->nullable()->default('client');
            $table->string('age', 100)->nullable();
            $table->integer('goal_id')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->double('point', null, 0)->nullable();
            $table->integer('sendReminder')->nullable()->default(0);
            $table->boolean('active')->nullable();
            $table->boolean('blocked')->nullable()->default(false);
            $table->boolean('compelete')->nullable()->default(true);
            $table->boolean('confirm')->nullable()->default(true);
            $table->boolean('send_notify')->nullable()->default(true);
            $table->double('price', null, 0)->nullable();
            $table->double('renewal_price', null, 0)->nullable();
            $table->tinyInteger('is_fav')->nullable()->default(0);
            $table->boolean('see_family')->nullable()->default(false);
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('goal_desc_ar')->nullable();
            $table->boolean('has_sons')->nullable()->default(false);
            $table->string('social_level', 100)->nullable();
            $table->string('level', 100)->nullable();
            $table->text('goals')->nullable();
            $table->text('communications')->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('width', 100)->nullable();
            $table->string('height', 100)->nullable();
            $table->string('eye_color', 100)->nullable();
            $table->string('hair_color', 100)->nullable();
            $table->string('skin_color', 100)->nullable();
            $table->string('job', 100)->nullable();
            $table->string('avatar', 191)->nullable()->default('/public/user.png');
            $table->string('avatar_edit')->nullable();
            $table->tinyInteger('edit_seen')->nullable()->default(1);
            $table->tinyInteger('avatar_seen')->nullable()->default(1);
            $table->integer('package_id')->nullable();
            $table->string('package_title')->nullable();
            $table->timestamp('package_date')->nullable();
            $table->timestamp('package_end_date')->nullable();
            $table->string('lat', 191)->nullable();
            $table->string('lng', 191)->nullable();
            $table->string('address_ar', 191)->nullable();
            $table->string('address_en')->nullable();
            $table->string('lang', 191)->nullable();
            $table->string('car_type')->nullable();
            $table->string('car_image')->nullable();
            $table->string('id_image')->nullable();
            $table->boolean('subscripe')->nullable()->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('gender')->nullable();
            $table->string('expert')->nullable();
            $table->string('full_name_ar')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('license_image')->nullable();
            $table->string('ecommercy_image')->nullable();
            $table->string('id_number')->nullable();
            $table->string('ecommercy_id')->nullable();
            $table->boolean('has_delivary')->nullable()->default(false);
            $table->double('delivary', null, 0)->nullable()->default(0);
            $table->float('delivery_time', null, 0)->nullable();
            $table->tinyInteger('login')->nullable()->default(0);
            $table->double('admin_percent', null, 0)->nullable()->default(0);
            $table->double('total', null, 0)->nullable()->default(0);
            $table->double('debt', null, 0)->nullable()->default(0);
            $table->double('total_user_benfit', null, 0)->nullable();
            $table->double('total_admin_benfit', null, 0)->nullable();
            $table->double('total_admin_recived', null, 0)->nullable();
            $table->double('total_user_recived', null, 0)->nullable();
            $table->double('total_admin_debt', null, 0)->nullable();
            $table->double('total_user_debt', null, 0)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_iban')->nullable();
            $table->tinyInteger('cash')->nullable()->default(1);
            $table->tinyInteger('transfer')->nullable()->default(0);
            $table->tinyInteger('online')->nullable()->default(1);
            $table->tinyInteger('not_now')->nullable()->default(0);
            $table->string('not_now_duration', 50)->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('sub_section_id')->nullable();
            $table->string('country_id', 191)->nullable();
            $table->string('city_id', 191)->nullable();
            $table->string('neighborhood_id', 191)->nullable();
            $table->unsignedInteger('role_id')->nullable()->index('users_role_id_foreign');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->text('api_token')->nullable();
            $table->rememberToken();
            $table->timestamp('login_date')->nullable();
            $table->timestamp('logout_date')->nullable();
            $table->timestamps();
            $table->string('secret_token')->nullable();
            $table->string('stripe_session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
