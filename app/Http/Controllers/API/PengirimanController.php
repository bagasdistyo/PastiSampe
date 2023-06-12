<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiFormatter;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $response = Http::get('http://127.0.0.1:8001/api/pemesanan');
        $responseData = json_decode($response->body());
    
        if ($response->status() === 200) {
            $savedData = [];
            foreach ($responseData->data as $item) {
                // Periksa apakah id_order sudah ada di database
                $existingData = Pengiriman::where('id_order', $item->id_order)->first();
                if (!$existingData) {
                    // Jika id_order tidak ada, simpan ke database
                    $data = Pengiriman::create([
                        'id_order' => $item->id_order,
                        'alamat_penerima' => $item->alamat_penerima,
                        'jenis_pengiriman' => $item->jenis_pengiriman,
                    ]);
                    $savedData[] = $data;
                }
            }
    
            return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $responseData);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mengambil data dari API');
        }
    }
    // public function index()
    // {
    //     $pengiriman = Pengiriman::all();

    //     if ($pengiriman) {
    //         return ApiFormatter::createApi(200, 'Permintaan berhasil, data pengiriman berhasil ditampilkan', $pengiriman);
    //     } else {
    //         return ApiFormatter::createApi(400, 'Failed');
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function jadwal(Request $request)
    {
        try {
            $request->validate([
                'no_resi' => 'required',
                'id_order' => 'required',
                'alamat_penerima' => 'required',
                'jenis_pengiriman' => 'required',
            ]);
    
            $jadwal_pengiriman = Carbon::today()->addDays(rand(1, 7))->toDateString();
    
            $pengiriman = Pengiriman::create([
                'no_resi' => $request->no_resi,
                'id_order' => $request->id_order,
                'alamat_penerima' => $request->alamat_penerima,
                'jenis_pengiriman' => $request->jenis_pengiriman,
                'jadwal_pengiriman' => $jadwal_pengiriman,
    
            ]);
    
            if ($pengiriman) {
                $pengirimanData = $pengiriman->toArray();
                $data = [
                    'no_resi' => $pengirimanData['no_resi'],
                    'id_order' => $pengirimanData['id_order'],
                    'alamat_penerima' => $pengirimanData['alamat_penerima'],
                    'jenis_pengiriman' => $pengirimanData['jenis_pengiriman'],
                    'jadwal_pengiriman' => $pengirimanData['jadwal_pengiriman'],
                ];
                return ApiFormatter::createApi(200, 'Permintaan berhasil, nomor resi dan informasi penjadwalan
                berhasil dikirimkan.', $data);
            } else {    
                return ApiFormatter::createApi(400, 'Permintaan berhasil, nomor resi dan informasi penjadwalan
                berhasil dikirimkan.');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, $error->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function kirim(Request $request, $no_resi)
    {
        try {
            $request->validate([
                'status' => 'required',
                'estimasi_waktu' => 'required',
            ]);
    
            $pengiriman = Pengiriman::where('no_resi', $no_resi)->first();
    
            if ($pengiriman) {
                $pengiriman->update([
                    'status' => $request->status,
                    'estimasi_waktu' => $request->estimasi_waktu,
                    'lokasi' => $request->lokasi,
                    'konfirmasi_pengiriman' => $request->konfirmasi_pengiriman,
                ]);
    
                $pengirimanData = $pengiriman->toArray();
                $data = [
                    'no_resi' => $pengirimanData['no_resi'],
                    'id_order' => $pengirimanData['id_order'],
                    'jadwal_pengiriman' => $pengirimanData['jadwal_pengiriman'],
                    'status' => $pengirimanData['status'],
                    'estimasi_waktu' => $pengirimanData['estimasi_waktu'],
                    'lokasi' => $pengirimanData['lokasi'],
                    'konfirmasi_pengiriman' => $pengirimanData['konfirmasi_pengiriman'],
                ];
                return ApiFormatter::createApi(200, 'Permintaan berhasil, informasi pengiriman dikirimkan', $data);
            } else {
                return ApiFormatter::createApi(400, 'Permintaan tidak valid, data yang diberikan tidak lengkap');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function lacak(string $no_resi)
    {
        $pengiriman = Pengiriman::where('no_resi', '=', $no_resi)->get();

        if ($pengiriman) {
            return ApiFormatter::createApi(200, 'Permintaan berhasil, lokasi barang dikirimkan.', $pengiriman);
        } else {
            return ApiFormatter::createApi(400, 'Permintaan tidak valid, data yang diberikan tidak lengkap');
        }
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function kiri(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
