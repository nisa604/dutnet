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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('id_pelanggan');
            $table->integer('id_checkout');
            $table->string('reference');
            $table->dateTime('waktu_transaksi');
            $table->integer('total_bayar');
            $table->string('jenis_pembayaran');

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
