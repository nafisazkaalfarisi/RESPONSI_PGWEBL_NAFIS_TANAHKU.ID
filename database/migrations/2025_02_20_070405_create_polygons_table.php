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
        Schema::create('polygons', function (Blueprint $table) {
    $table->id();
    $table->geometry('geom');
    $table->string('name');
    $table->text('description');
    $table->double('area_m2')->nullable();
    $table->string('certificate')->nullable();   // SHM, SHGB, AJB, dll
    $table->string('land_use')->nullable();      // perumahan, sawah, dll
    $table->string('road_access')->nullable();   // sempit, sedang, lebar
    $table->string('district')->nullable();      // Kecamatan
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('image')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polygons');
    }
};
