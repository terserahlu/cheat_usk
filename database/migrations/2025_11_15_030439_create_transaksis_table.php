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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idkasir')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('idorderan')->references('id')->on('orderans')->onDelete('cascade');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
