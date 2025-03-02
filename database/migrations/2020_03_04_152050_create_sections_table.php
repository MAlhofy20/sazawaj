<?php

use App\Models\Section;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->longText('short_desc_ar')->nullable();
            $table->longText('short_desc_en')->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->double('price')->nullable();
            $table->double('point')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Section::create([
            'title_ar' => '20 قارورة * 330 مل',
            'title_en' => '20 vials * 330 ml',
            'price'    => '12',
            'point'    => '100',
            'image'    => '/public/none.png',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
