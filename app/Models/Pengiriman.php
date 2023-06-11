<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'pengiriman';
    protected $primaryKey = 'no_resi';
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'alamat_penerima',
        'jenis_pengiriman',
        'jadwal_pengiriman',
        'estimasi_waktu',
        'status',
        'lokasi',
        'konfirmasi_pengiriman',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_order', 'id_order');
    }
}
