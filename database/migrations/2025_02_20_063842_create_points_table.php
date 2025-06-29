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
        Schema::create('points', function (Blueprint $table) {
    $table->id();
    $table->geometry('geom');
    $table->string('name');
    $table->text('description');
    $table->string('image')->nullable();
    $table->bigInteger('price')->nullable();
    $table->string('status')->nullable();
    $table->string('contact')->nullable();
    $table->string('village')->nullable();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
