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
            $table->integer('id_order'); //dari sales
            $table->string('alamat_penerima')->nullable()->default(null);
            $table->string('jenis_pengiriman')->nullable()->default(null);
            $table->date('jadwal_pengiriman')->nullable()->default(null);
            $table->integer('estimasi_waktu')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->string('lokasi')->nullable()->default(null);
            $table->string('konfirmasi_pengiriman')->nullable()->default(null);
            $table->timestamps();
    

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
