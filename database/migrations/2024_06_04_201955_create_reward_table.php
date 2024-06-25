<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('rewards')) {
            Schema::create('rewards', function (Blueprint $table) {
                $table->id();
                $table->string('id_pelanggan');
                $table->integer('recency');
                $table->integer('frequency');
                $table->integer('monetary');
                $table->integer('engagement');
                $table->integer('total_score');
                // $table->string('actual_score');
                $table->string('segmentasi');
                $table->integer('reward');
                $table->timestamps();

                $table->foreign('id_pelanggan')->references('id_pelanggan')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward');
    }
};
