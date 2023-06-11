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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->increments('no_resi');
            $table->unsignedInteger('id_order');
            $table->string('alamat_penerima');
            $table->string('jenis_pengiriman');
            $table->date('jadwal_pengiriman')->nullable()->default(null);
            $table->integer('estimasi_waktu')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->string('lokasi')->nullable()->default(null);
            $table->string('konfirmasi_pengiriman')->nullable()->default(null);
            $table->timestamps();
    
            $table->foreign('id_order')->references('id_order')->on('pesanan');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
