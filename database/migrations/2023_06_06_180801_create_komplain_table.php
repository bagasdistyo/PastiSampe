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
        Schema::create('komplain', function (Blueprint $table) {
            $table->increments('id_komplain');
            $table->unsignedInteger('no_resi');
            $table->date('tanggal_komplain');
            $table->text('deskripsi_komplain');
            $table->string('status_komplain');

            $table->foreign('no_resi')->references('no_resi')->on('pengiriman');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komplain');
    }
};
