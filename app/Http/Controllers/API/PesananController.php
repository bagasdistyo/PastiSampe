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
        // Simpan data ke database
        foreach ($responseData->data as $item) {
            Pesanan::create([
                'id_order' => $item->id_order,
                'nama_barang' => $item->nama_barang,
                'alamat_penerima' => $item->alamat_penerima,
                'jenis_pengiriman' => $item->jenis_pengiriman,
                'berat_barang' => $item->berat_barang
            ]);
        }

        return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $responseData->data);
    } else {
        return ApiFormatter::createApi(400, 'Gagal mengambil data dari API');
    }


    
        // if ($data) {
        //     return ApiFormatter::createApi(200, 'Permintaan berhasil, data pesanan berhasil ditampilkan', $data);
        // } else {
        //     return ApiFormatter::createApi(400, 'Failed');
        // }
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
    public function ongkir(Request $request)
    {
        try {
            $request->validate([
                'id_order' => 'required',
                'id_customer' => 'required',
                'nama_barang' => 'required',
                'alamat_penerima' => 'required',
                'jenis_pengiriman' => 'required',
                'berat_barang' => 'required',
            ]);

            $harga_ongkir = rand(5000, 25000);
            $pesanan = Pesanan::create([
                'id_order' => $request->id_order,
                'id_customer' => $request->id_customer,
                'nama_barang' => $request->nama_barang,
                'alamat_penerima' => $request->alamat_penerima,
                'jenis_pengiriman' => $request->jenis_pengiriman,
                'berat_barang' => $request->berat_barang,
                'harga_ongkir' => $harga_ongkir,

            ]);

            $pesanan = Pesanan::where('id_order', $request->id_order)->first();

            if ($pesanan) {
                return ApiFormatter::createApi(200, '“Permintaan berhasil, Estimasi harga ongkir berhasil dikirim', $pesanan);
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
