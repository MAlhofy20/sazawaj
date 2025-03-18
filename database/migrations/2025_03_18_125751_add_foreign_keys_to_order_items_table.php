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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_items_ibfk_1')->references(['id'])->on('orders')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['service_id'], 'order_items_ibfk_2')->references(['id'])->on('services')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['section_id'], 'order_items_ibfk_3')->references(['id'])->on('sections')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_items_ibfk_1');
            $table->dropForeign('order_items_ibfk_2');
            $table->dropForeign('order_items_ibfk_3');
        });
    }
};
