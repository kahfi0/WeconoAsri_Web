<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(){
        $transaksiPending['listPending'] = Transaksi::whereStatus("MENUNGGU")->get();

        $transaksiSelesai['listDone'] = Transaksi::where("Status", "NOT LIKE", "%MENUNGGU%")->get();
        return view('transaksi')->with($transaksiPending)->with($transaksiSelesai);
    }

    public function batal($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->PushNotif('Transaksi Dibatalkan',"Transaksi Produk ".  $transaksi->details[0]->produk->name ." Berhasil Dibatalkan", $transaksi->user->fcm);

        if ($transaksi) {
            //update data
            $transaksi->update([
                'status' => "BATAL"
            ]);
            return redirect('transaksi');
        }
    }

    public function confirm($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->PushNotif('Transaksi Diproses',"Transaksi Produk ".  $transaksi->details[0]->produk->name ." Sedang diproses", $transaksi->user->fcm);

        if ($transaksi) {
            //update data
            $transaksi->update([
                'status' => "PROSES"
            ]);
            return redirect('transaksi');
        }
    }

    public function kirim($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->PushNotif('Transaksi Dikirim',"Transaksi Produk ".  $transaksi->details[0]->produk->name ." Sedang dalam pengiriman", $transaksi->user->fcm);

        if ($transaksi) {
            //update data
            $transaksi->update([
                'status' => "DIKIRIM"
            ]);
            return redirect('transaksi');
        }
    }

    public function selesai($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->PushNotif('Transaksi Selesai',"Transaksi Produk ".  $transaksi->details[0]->produk->name ." Sudah selesai", $transaksi->user->fcm);

        if ($transaksi) {
            //update data
            $transaksi->update([
                'status' => "SELESAI"
            ]);
            return redirect('transaksi');
        }
    }

    public function pushNotif( $title, $message) {


        $mData = [
            'title' =>$title,
            'body' => $message
        ];

        $fcm[] = "f3UXSiA-RbCKhgEJARzx7d:APA91bH2WL_FxcVWfa2i5-nrAYPGnDHv2ky1fX6J9WiUiZ_rj2L0KtSf7LtLvks5-2o8X2pkEqfwTb6VQoU-GjNy7uNnyCrYkwHsfiFkRCS3V63h5bdrA2XA4mN2HQoR27nDD0c39SP4";

        $payload = [
            'registration_ids' => $fcm,
            'notification' => $mData
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: key=AAAA2pqxdm4:APA91bH2T-jXU_J6wvjPeW30zhcNB1mtUmLyPapdGJtiPTuYW5twSpz8iwx1WkMOLcqGMgsR2bvEFcEjJPIYB2nVYaJPFzx1DSPw9N9leHhPs9y8kKt14FZHku88k39Al_s-kVLUh_Eo"
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = [
            'success' => 1,
            'message' => "Push notif success",
            'data' => $mData,
            'firebase_response' => json_decode($response)
        ];
        return $data;
    }
}
