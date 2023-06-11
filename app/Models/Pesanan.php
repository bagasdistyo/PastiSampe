<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_order',
        'id_customer',
        'nama_barang',
        'alamat_penerima',
        'jenis_pengiriman',
        'berat_barang',
        'harga_ongkir'
    ];

    // Nama tabel yang digunakan oleh model
    protected $table = 'pesanan';

    // Kolom yang dianggap sebagai kunci utama (secara default, Eloquent mengasumsikan kolom 'id' sebagai kunci utama)
    protected $primaryKey = 'id_ongkir';

    // Menyatakan bahwa kunci utama adalah inkremen
    public $incrementing = true;

    // Menyatakan bahwa tidak ada kolom timestamp (created_at dan updated_at) pada tabel
    public $timestamps = false;
}
