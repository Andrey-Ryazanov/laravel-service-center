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
        Schema::create('service_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique();
            $table->string('phone', 12);
            $table->string('address');
            $table->time('start_working_hours');
            $table->time('end_working_hours');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('service_contacts');
    }
};
