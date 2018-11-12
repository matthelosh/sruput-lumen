<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Praktikan;
use App\Syarat;
class PraktikanController extends Controller
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
            $import = Praktikan::create([
                'uname' => $datas[$i]['uname'], 
                'password' => Hash::make($datas[$i]['password']),
                'nis' => $datas[$i]['nis'],
                'nama' => $datas[$i]['nama'], 
                'kelas' => $datas[$i]['kelas'], 
                'periode' => $datas[$i]['periode'], 
                'hp' => $datas[$i]['hp'], 
                'hp_ortu' => $datas[$i]['hp_ortu'], 
                'alamat' => $datas[$i]['alamat'], 
                '_role' => $datas[$i]['_role'], 
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

    public function regOne (Request $request)
    {
        $data = $request->all();
        // $reg = Praktikan::create([
        //        'uname' => $data, 
        //         'password' => Hash::make($datas[$i]['password']),
        //         'nis' => $datas[$i]['nis'],
        //         'nama' => $datas[$i]['nama'], 
        //         'kelas' => $datas[$i]['kelas'], 
        //         'periode' => $datas[$i]['periode'], 
        //         'hp' => $datas[$i]['hp'], 
        //         'hp_ortu' => $datas[$i]['hp_ortu'], 
        //         'alamat' => $datas[$i]['alamat'], 
        //         '_role' => $datas[$i]['_role'], 
        //         'isActive' => $datas[$i]['isActive']
        // ])
        return response()->json(['msg'=>$data]);
    }

    public function getSiswas (Request $request)
    {
        $periode = $request->periode;
        $siswas = Praktikan::where('periode', $periode)->get();

        if ($siswas) {
            return response()->json([
                'success' => true,
                'data' => $siswas
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => ''
            ], 404);
        }
    }

    public function delete(Request $request, $uname)
    {
        $uname = $uname;
        $remove = Praktikan::where('uname', $uname)->delete();

        if ($remove) {
            return response()->json([
                'success' => true,
                'msg' => 'Praktikan dengan Username: '.$uname.' dihapus',
                'data' => $remove
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'msg' => 'Praktikan dengan Username: '.$uname.' gagal dihapus',
                'data' => ''
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $siswa = Praktikan::find($id);

        $siswa->uname = $request->uname;
        $siswa->password = Hash::make($request->password);
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->periode = $request->periode;
        $siswa->hp = $request->hp;
        $siswa->hp_ortu = $request->hp_ortu;
        $siswa->alamat = $request->alamat;
        $siswa->_role = $request->_role;
        $siswa->isActive = $request->isActive;

        $update = $siswa->save();

        if ( $update ) {
            return response()->json(["success" => true, "msg" => "Data Praktikan berhasil diperbarui"], 201);
        } else {
            return response()->json(["success" => false, "msg"=>"Pembaruan data praktikan gagal"]);
        }
    }

//    Get Praktikan by Periode
    public function getByPeriode(Request $request)
    {
        $periode = $request->periode;
        $siswas = Praktikan::where('periode', $periode)->get();
        if ( $siswas ) {
            return response()->json([
                'success' => true,
                    'msg' => 'Siswa found',
                    'data' => $siswas
                ], 200);
        } else {
            return response()->json([
                    'success' => false,
                    'msg' => 'Siswa found',
                    'data' => ''
                ], 404);
        }
//        return response()->json(['msg' => $request->periode]);
    }

    public function getCalons (Request $request)
        {
            $periode = $request->periode;
            $Praktikans = Praktikan::where('periode', $periode)->where('isActive', '0')->get();

            if ($Praktikans) {
                return response()->json([
                    'success' => true,
                    'data' => $Praktikans
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => ''
                ], 404);
            }
        }

    
}
