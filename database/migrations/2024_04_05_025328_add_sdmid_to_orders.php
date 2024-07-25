<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('sdm_id')->nullable();
            $table->foreign('sdm_id')->references('id_sdm')->on('service_delivery_methods')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['sdm_id']); // Удаление внешнего ключа
            $table->dropColumn('sdm_id'); // Удаление столбца
        });
    }
};
