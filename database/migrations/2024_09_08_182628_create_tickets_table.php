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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->unsignedBigInteger('documents_id')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->char('status');
            $table->boolean('current')->default(true);
            $table->timestamps();
            //Definicion de claves foraneas 
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('documents_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
