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
        Schema::create('detail_pembelian_voucher', function (Blueprint $table) {
            $table->id();
            $table->integer('id_checkout');
            $table->integer('id_pelanggan');
            $table->string('reference')->nullable();
            $table->string('nama_jenis_voucher');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->string('status_bayar');
            $table->string('jenis_pembayaran');
            
            $table->index('nama_jenis_voucher');
            $table->foreign('nama_jenis_voucher')->references('nama_jenis_voucher')->on('jenis_voucher');
        });
        
    }
    
    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian_voucher');
    }
};
