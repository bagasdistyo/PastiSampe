<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiFormatter;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use App\Models\Komplain;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class KomplainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komplain = Komplain::all();

        if ($komplain) {
            return ApiFormatter::createApi(200, 'Permintaan berhasil, data komplain berhasil ditampilkan', $komplain);
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
    public function pengembalian(Request $request)
    {
        try {
            $request->validate([
                'no_resi' => 'required',
                'tanggal_komplain' => 'required',
                'deskripsi_komplain' => 'required',
                'status_komplain' => 'required',
            ]);
    
            $komplain = Komplain::create([
                'id_komplain' => $request->id_komplain,
                'no_resi' => $request->no_resi,
                'tanggal_komplain' => $request->tanggal_komplain,
                'deskripsi_komplain' => $request->deskripsi_komplain,
                'status_komplain' => $request->status_komplain,
            ]);
    
            if ($komplain) {
                $response = [
                    'id_komplain' => $komplain->id_komplain,
                    'no_resi' => $komplain->no_resi,
                    'tanggal_komplain' => $komplain->tanggal_komplain,
                    'deskripsi_komplain' => $komplain->deskripsi_komplain,
                    'status_komplain' => $komplain->status_komplain,
                ];
    
                return ApiFormatter::createApi(200, 'Permintaan berhasil, pengembalian barang diproses', $response);
            } else {    
                return ApiFormatter::createApi(400, 'Permintaan tidak valid, data yang diberikan tidak lengkap atau tidak sesuai format');
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
