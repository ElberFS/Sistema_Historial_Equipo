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
        Schema::create('device_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('tickets_id')->nullable();
            $table->unsignedBigInteger('documents_id')->nullable();
            $table->unsignedBigInteger('devices_id');
            $table->boolean('current')->default(true);
            $table->timestamps();

            //definicion de claves foraneas 
            $table->foreign('documents_id')->references('id')->on('documents');
            $table->foreign('tickets_id')->references('id')->on('tickets');
            $table->foreign('devices_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_tickets');
    }
};
