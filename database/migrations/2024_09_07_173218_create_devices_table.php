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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('areas_id');
            $table->unsignedBigInteger('device_types_id');
            $table->string('serial_number');
            $table->boolean('current')->default(true);
            $table->timestamps();

            //definicion de claves foraneas 

            $table->foreign('areas_id')->references('id')->on('areas');
            $table->foreign('devices_types_id')->references('id')->on('device_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
