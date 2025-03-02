<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('code')->nullable();
            $table->string('user_type')->nullable(); //admin , client
            $table->double('point')->nullable();
            $table->boolean('sendReminder')->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('blocked')->nullable();
            $table->boolean('compelete')->nullable();
            $table->string('avatar')->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address')->nullable();
            $table->string('lang')->nullable();
            $table->string('country_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('neighborhood_id')->nullable();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert some stuff
        $user = new User;
        $user->first_name = 'المدير العام';
        $user->email      = 'admin@info.com';
        $user->password   = '123456';
        $user->phone      = '0541867992';
        $user->address    = 'السعودية - الرياض';
        $user->avatar     = '/public/user.png';
        $user->lang       = 'ar';
        $user->user_type  = 'admin';
        $user->role_id    = Role::first()->id;
        $user->active     = 1;
        $user->blocked    = 0;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
