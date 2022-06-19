<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produk;

class ProdukController extends Controller
{
    public function index(){
    $produk = Produk::all();

        return response()->json([
            'success' => 1,
            'message' => 'Get Produk Berhasil',
            'produks' => $produk
        ]);
    }

    public function delete(Request $request){
        $produk = Produk::where('id', $request->id)->first();
        if ($produk){
            $produk->delete();
            return response()->json([
                'success' => 1,
                'message' => 'Produk berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'success' => 0,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
    }

}