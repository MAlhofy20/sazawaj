<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        $site_name = Setting::firstOrCreate(['key' => 'site_name']);
        $site_name->value = 'Gdwa';
        $site_name->save();

        $site_logo = Setting::firstOrCreate(['key' => 'site_logo']);
        $site_logo->value = '/public/site_logo.png';
        $site_logo->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
