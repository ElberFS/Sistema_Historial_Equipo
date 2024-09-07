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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->String('title');
            $table->string('description');
            $table->unsignedBigInteger('managers_id');
            $table->unsignedBigInteger('device_tickets_id');
            $table->boolean('current')->default(true);
            $table->timestamps();

            //definicion de claves foraneas 
            $table->foreign('device_tickets_id')->references('id')->on('device_tickets');        
            $table->foreign('managers_id')->references('id')->on('managers');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
