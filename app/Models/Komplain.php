<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    use HasFactory;
    protected $table = 'komplain';
    protected $primaryKey = 'id_komplain';
    public $timestamps = false;

    protected $fillable = [
        'no_resi',
        'tanggal_komplain',
        'deskripsi_komplain',
        'status_komplain',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pengiriman::class, 'no_resi', 'no_resi');
    }
}
