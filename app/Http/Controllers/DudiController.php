<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Dudi;
class DudiController extends Controller
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

        // 'uname', 'password', 'api_token','nis', 'name', 'kelas','periode', 'hp', 'hp_ortu', 'alamat', '_role', 'isActive'
        $jml = count($datas);
        $i=0;

        // return response()->json(['msg'=>$jml]);
        while($i < $jml) {
            $import = Dudi::create([
                'kode_dudi' => $datas[$i]['kode_dudi'], 
                'nama_dudi' => $datas[$i]['nama_dudi'], 
                'alamat' => $datas[$i]['alamat'],
                'kota' => $datas[$i]['kota'], 
                'pemilik' => $datas[$i]['pemilik'], 
                'telp' => $datas[$i]['telp'], 
                'email' => $datas[$i]['email'], 
                'kuota' => $datas[$i]['kuota'], 
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

    public function getDudis (Request $request)
    {
        // $periode = $request->periode;
        $dudis = Dudi::all();

        if ($dudis) {
            return response()->json([
                'success' => true,
                'data' => $dudis
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => ''
            ], 404);
        }
    }

    public function delete(Request $request, $id)
    {
        $remove = Dudi::where('id', $id)->delete();

        if ($remove) {
            return response()->json([
                'success' => true,
                'msg' => 'Dudi berhasil dihapus',
                'data' => $remove
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'msg' => 'Dudi gagal dihapus',
                'data' => ''
            ], 400);
        }

        // return response()->json(['msg'=>$id]);
    }

    public function getLast(Request $request)
    {
        $kode = $request->kode;
        $dudi = Dudi::where('kode_dudi', 'like', $kode.'%')->orderBy('id', 'desc')->first();

        if ( $dudi ) {
            return response()->json([
                'success' => true,
                'msg' => 'Dudi ditemukan',
                'data' => $dudi
            ]);
        }
    }

    public function add(Request $request)
    {

        $add = Dudi::create([
                'kode_dudi' => $request->input('kode_dudi'), 
                'nama_dudi' => $request->input('nama_dudi'), 
                'alamat' => $request->input('alamat'),
                'kota' => $request->input('kota'), 
                'pemilik' => $request->input('pemilik'), 
                'telp' =>$request->input('telp'), 
                'email' => $request->input('email'), 
                'kuota' => $request->input('kuota')
            ]);

        if ( $add ) {
            return response()->json([
                'success' => true,
                'msg' => 'Dudi baru ditambahkan',
                'data' => $add
            ]);
        } else {
             return response()->json([
                'success' => false,
                'msg' => 'Dudi baru gagal ditambahkan',
                'data' => ''
            ]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $dudi = Dudi::find($id);

        $dudi->kode_dudi = $request->kode_dudi;
        $dudi->nama_dudi = $request->nama_dudi;
        $dudi->alamat = $request->alamat;
        $dudi->kota = $request->kota;
        $dudi->pemilik = $request->pemilik;
        $dudi->telp = $request->telp;
        $dudi->email = $request->email;
        $dudi->kuota = $request->kuota;

        $update = $dudi->save();

        if ( $update ) {
            return response()->json(["success" => true, "msg" => "Data Dudi berhasil diperbarui"], 201);
        } else {
            return response()->json(["success" => false, "msg"=>"Pembaruan data Dudi gagal"]);
        }
    } 
}
