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
        Schema::create('jenis_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis_voucher')->unique();
            $table->string('masa_berlaku');
            $table->string('kecepatan');
            $table->float('bobot', 8, 2);
            $table->integer('harga');
            $table->integer('stok_tersedia');
            $table->integer('stok_terjual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_voucher');
    }
};
