<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PesananController;
use App\Http\Controllers\API\PengirimanController;
use App\Http\Controllers\API\KomplainController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route untuk mengambil dan menyimpan data pesanan dari API Sales
Route::get('pesanan', [PesananController::class, 'index']);

// Route untuk menampilkan seluruh data pesanan
Route::get('pesanan/data_pesanan', [PesananController::class, 'data_pesanan']);

// Route untuk mengirim harga ongkir
Route::post('pesanan/ongkir/{id_order}', [PesananController::class, 'ongkir']);

// Route untuk mengambil dan menyimpan data pesanan dari API Sales
Route::get('pengiriman', [PengirimanController::class, 'index']);

// Route untuk menampilkan seluruh data pengiriman
Route::get('pengiriman/data_pengiriman', [PengirimanController::class, 'data_pengiriman']);

// Route untuk mengirimkan jadwal pengiriman dan nomor resi
Route::post('pengiriman/jadwal/{no_resi}', [PengirimanController::class, 'jadwal']);

// Route untuk update data pengiriman untuk mengubah status, estimasi_waktu, lokasi, dan konfirmasi pengiriman
Route::post('pengiriman/kirim/{no_resi}', [PengirimanController::class, 'kirim']);

// Route untuk melacak lokasi paket berdasarkan nomor resi
Route::get('pengiriman/lacak/{no_resi}', [PengirimanController::class, 'lacak']);

// Route untuk menampilkan seluruh data komplain
Route::get('komplain', [KomplainController::class, 'index']);

// Route untuk mengirim data komplain
Route::post('komplain/pengembalian', [KomplainController::class, 'pengembalian']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
