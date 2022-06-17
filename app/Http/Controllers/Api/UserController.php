<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {

        // dd($request->all()); die();
        $user = User::where('email', $request->email)->first();

        if ($user) {

            $user->update([
                'fcm' => $request->fcm
            ]);


            if(password_verify($request->password, $user->password)){
                return response()->json([
                    'success' => 1,
                    'message' => 'Selamat datang, '.$user->name,
                    'user' => $user
                ]);
            }
            return $this->error('Password Salah');
        }

        return $this->error('Email tidak terdaftar');
    }

    public function register(Request $request){
        //nama, email, password
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        //input data kedatabase
        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password)
        ]));

        if($user){
        return response()->json([
            'success' => 1,
            'message' => 'Selamat datang, Register Berhasil',
            'user' => $user
        ]);
    }

    return $this->error('Registrasi Gagal');

}

    public function error($pesan){
        return response()->json([
            'success' => 0,
            'message' => $pesan
        ]);
    }
}

