<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Guru;
class GuruController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // $password = Hash::make($request->input('password'));
    public function import (Request $request) 
    {
        $datas = $request->all();

        $i=0;
        while($datas) {
            $import = Guru::create([
                'kode_guru' => $datas[$i]['kode_guru'], 
                'uname' => $datas[$i]['uname'],
                'password' => Hash::make($datas[$i]['password']),
                'name' => $datas[$i]['name'], 
                'alamat' => $datas[$i]['alamat'], 
                'hp' => $datas[$i]['hp'], 
                '_role' => $datas[$i]['role'], 
                'isActive' => $datas[$i]['isActive']
            ]);
            
            $i++;
        }

        if ( $import ) {
            return response()->json([
                'success' => true,
                'msg' => 'Sukses import',

            ], 201);
        } else {
             return response()->json([
                'success' => false,
                'msg' => 'Gagal import',

            ], 400);
        }
    }

    public function getGurus(Request $request)
    {
        $gurus = Guru::all();

        if ($gurus) {
            return response()->json([
                'success' => true,
                'data' => $gurus
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => ''
            ], 404);
        }
    }
}
