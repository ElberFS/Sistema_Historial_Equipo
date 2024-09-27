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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('tickets_id');
            $table->unsignedBigInteger('device_tickets_id');
            $table->string('process');
            $table->boolean('current')->default(true);
            $table->timestamps();

            //definicion de claves foraneas
            $table->foreign('tickets_id')->references('id')->on('tickets');
            $table->foreign('device_tickets_id')->references('id')->on('device_tickets');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
