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
        Schema::create('orderans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idwaiter')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('idmenu')->references('id')->on('menus')->onDelete('cascade');
            $table->foreignId('idpelaggan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreignId('idmeja')->references('id')->on('mejas')->onDelete('cascade');
            $table->unsignedBigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderans');
    }
};
