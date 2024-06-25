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
        Schema::create('voucher', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_jenis');
        $table->integer('id_checkout')->nullable();
        $table->string('kode_voucher')->unique();
        $table->string('status_voucher');
        $table->integer('harga_voucher');

        $table->timestamps();

        $table->foreign('id_jenis')->references('id')->on('jenis_voucher');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
