<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiFormatter;
use App\Models\Pesanan;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $pesanan = Pesanan::all();

    //     if ($pesanan) {
    //         return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $pesanan);
    //     } else {
    //         return ApiFormatter::createApi(400, 'Failed');
    //     }
        
    // }

    public function index(Request $request)
    {
        $response = Http::get('http://127.0.0.1:8001/api/pemesanan');
        $responseData = json_decode($response->body());
    
        if ($response->status() === 200) {
            $savedData = [];
            foreach ($responseData->data as $item) {
                // Periksa apakah id_order sudah ada di database
                $existingData = Pesanan::where('id_order', $item->id_order)->first();
                if (!$existingData) {
                    // Jika id_order tidak ada, simpan ke database
                    $data = Pesanan::create([
                        'id_order' => $item->id_order,
                        'nama_barang' => $item->nama_barang,
                        'alamat_penerima' => $item->alamat_penerima,
                        'jenis_pengiriman' => $item->jenis_pengiriman,
                        'berat_barang' => $item->berat_barang
                    ]);
                    $savedData[] = $data;
                }
            }
    
            return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $responseData);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mengambil data dari API');
        }
    }
    

    public function data_pesanan()
    {
        $pesanan = Pesanan::all();

        if ($pesanan) {
            return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $pesanan);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function ongkir(Request $request, $id_order)
    {
        $pesanan = Pesanan::all();
        // try {
        //     $request->validate([
        //         'id_order' => 'required',
        //     ]);

        //     $harga_ongkir = rand(5000, 25000);
        //     $pesanan = Pesanan::create([
        //         'id_order' => $request->id_order,
        //         'nama_barang' => $nama_barang,
        //         'alamat_penerima' => $alamat_penerima,
        //         'jenis_pengiriman' => $jenis_pengiriman,
        //         'berat_barang' => $berat_barang,
        //         'harga_ongkir' => $harga_ongkir,

        //     ]);

        //     $pesanan = Pesanan::where('id_order', $request->id_order)->first();

        //     if ($pesanan) {
        //         return ApiFormatter::createApi(200, '“Permintaan berhasil, Estimasi harga ongkir berhasil dikirim', $pesanan);
        //     } else {    
        //         return ApiFormatter::createApi(400, 'Permintaan tidak valid, data yang diberikan tidak lengkap');
        //     }
        // } catch (Exception $error) {
        //     return ApiFormatter::createApi(400, $error->getMessage());
        // }
        try {
            $request->validate([
                'harga_ongkir' => 'required',
            ]);
    
            $pesanan = Pesanan::where('id_order', $id_order)->first();
    
            if ($pesanan) {
                $pesanan->update([
                    'harga_ongkir' => $request->harga_ongkir,
                ]);
    
                $pesananData = $pesanan->toArray();
                $data = [
                    'id_ongkir' => $pesananData['id_ongkir'],
                    'id_order' => $pesananData['id_order'],
                    'nama_barang' => $pesananData['nama_barang'],
                    'alamat_penerima' => $pesananData['alamat_penerima'],
                    'jenis_pengiriman' => $pesananData['jenis_pengiriman'],
                    'berat_barang' => $pesananData['berat_barang'],
                    'harga_ongkir' => $pesananData['harga_ongkir'],
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
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
