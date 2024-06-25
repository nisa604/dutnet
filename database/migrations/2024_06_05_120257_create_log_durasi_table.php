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
        Schema::create('kunjungan_page', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            // $table->timestamp('login_time');
            // $table->timestamp('logout_time')->nullable();
            // $table->integer('duration')->nullable();
            // $table->string('url')->nullable();
            $table->integer('engagement')->nullable();
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
        Schema::dropIfExists('kunjungan_page');
    }
};
