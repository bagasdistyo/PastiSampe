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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id_order'); //dari sales
            $table->integer('id_customer'); //dari sales
            $table->string('nama_barang'); //dari sales
            $table->string('alamat_penerima'); //dari sales
            $table->string('jenis_pengiriman'); //dari sales
            $table->float('berat_barang'); //dari sales
            $table->float('harga_ongkir')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
