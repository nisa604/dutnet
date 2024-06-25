<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('reference');
            $table->dateTime('waktu_transaksi');
            $table->integer('total_bayar');
            $table->string('jenis_pembayaran');
            $table->string('nama_jenis_voucher');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat');
    }
};
