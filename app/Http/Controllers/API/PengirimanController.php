<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiFormatter;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


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
             // Check if the data array is empty
             if (empty($responseData->data)) {
                 return ApiFormatter::createApi(400, 'Data pada API Sales masih kosong');
             }
     
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
     
             return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil disimpan', $responseData);
         } else {
             return ApiFormatter::createApi(400, 'Gagal mengambil data dari API');
         }
     }
     

    public function data_pengiriman()
    {
        $pengiriman = Pengiriman::all();

        if ($pengiriman) {
            return ApiFormatter::createApi(200, 'Permintaan berhasil, data pengiriman berhasil ditampilkan', $pengiriman);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function jadwal(Request $request, $no_resi)
    {
        $pengiriman = Pengiriman::all();
        try {
            $request->validate([
                'jadwal_pengiriman' => 'required',
            ]);
            
            $pengiriman = Pengiriman::where('no_resi', $no_resi)->first();
    
            if ($pengiriman) {
                $pengiriman->update([
                    'jadwal_pengiriman' => $request->jadwal_pengiriman,
                ]);
                return ApiFormatter::createApi(200, 'Permintaan berhasil, informasi pengiriman dikirimkan', $pengiriman);
            } else {
                return ApiFormatter::createApi(400, 'Permintaan tidak valid, data yang diberikan tidak lengkap');
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
                'lokasi' => 'required',
                'konfirmasi_pengiriman' => 'required',
            ]);
    
            $pengiriman = Pengiriman::where('no_resi', $no_resi)->first();
    
            if ($pengiriman) {
                $pengiriman->update([
                    'status' => $request->status,
                    'estimasi_waktu' => $request->estimasi_waktu,
                    'lokasi' => $request->lokasi,
                    'konfirmasi_pengiriman' => $request->konfirmasi_pengiriman,
                ]);

                return ApiFormatter::createApi(200, 'Permintaan berhasil, informasi pengiriman dikirimkan', $pengiriman);
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
