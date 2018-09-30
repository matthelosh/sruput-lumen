<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Prakerlap;
use App\Dudi;
use App\Praktikan;
use App\Guru;
class PrakerlapController extends Controller
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
            $import = Prakerlap::create([
                'kode_Prakerlap' => $datas[$i]['kode_Prakerlap'], 
                'nama_Prakerlap' => $datas[$i]['nama_Prakerlap'], 
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

    public function getPrakerlaps (Request $request)
    {
        // $periode = $request->periode;
        $Prakerlaps = Prakerlap::all();

        if ($Prakerlaps) {
            return response()->json([
                'success' => true,
                'data' => $Prakerlaps
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => ''
            ], 404);
        }
    }
    // public function countRegd(Request $request)
    // {
    //     $periode = $request->periode;
    //     $Regd = Prakerlap::where('periode', $periode)->get();
    //     $jml = count($Regd);
    //     if ( $Regd ) {
    //         return response()->json([
    //             'success' => true,
    //             'msg' => 'Jumlah terdaftar periode '.$periode,
    //             'data' => $jml
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'msg' => 'Jumlah terdaftar periode '.$periode.' masih kosong',
    //             'data' => ''
    //         ], 404);
    //     }
    // }

    public function regdSiswa (Request $request)
    {
        $periode = $request->periode;
        $results = Prakerlap::where('prakerlaps.periode', $periode)
                 ->select('prakerlaps.*', 'praktikans.nis', 'praktikans.nama', 'praktikans.kelas', 'gurus.kode_guru', 'gurus.name', 'dudis.kode_dudi', 'dudis.nama_dudi', 'dudis.kuota')
                 ->join('praktikans', 'prakerlaps._siswa', '=', 'praktikans.nis')
                 ->join('gurus', 'prakerlaps._guru', '=', 'gurus.kode_guru')
                 ->join('dudis', 'prakerlaps._dudi', '=', 'dudis.kode_dudi')
                 ->get();
        $jml = count($results);
        if ($results){
            return response()->json(['success' => true, "msg" => 'Data Penempatan', 'data' => $results, 'jml' =>$jml], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Data Penempatan Kosong'], 404);
        }
    }

    // Get Not Scored Siswa
    public function notScored (Request $request)
        {
            $periode = $request->periode;
            $results = Prakerlap::where('prakerlaps.periode', $periode)
                     ->where('prakerlaps.scored', '0')
                     ->where('prakerlaps.status', 'selesai')
                     ->select('prakerlaps.*', 'praktikans.nis', 'praktikans.nama', 'praktikans.kelas', 'gurus.kode_guru', 'gurus.name', 'dudis.kode_dudi', 'dudis.nama_dudi', 'dudis.kuota')
                     ->join('praktikans', 'prakerlaps._siswa', '=', 'praktikans.nis')
                     ->join('gurus', 'prakerlaps._guru', '=', 'gurus.kode_guru')
                     ->join('dudis', 'prakerlaps._dudi', '=', 'dudis.kode_dudi')
                     ->get();
            $jml = count($results);
            if ($results){
                return response()->json(['success' => true, "msg" => 'Data Penempatan', 'data' => $results, 'jml' =>$jml], 200);
            } else {
                return response()->json(['success' => false, 'msg' => 'Data Penempatan Kosong'], 404);
            }
        }

        // Scored
    // public function scored (Request $request)
    //     {
    //         $periode = $request->periode;
    //         $results = Prakerlap::where('prakerlaps.periode', $periode)
    //                  ->where('prakerlaps.scored', '1')
    //                  ->where('prakerlaps.status', 'selesai')
    //                  ->select('prakerlaps.*', 'praktikans.nis', 'praktikans.nama', 'praktikans.kelas', 'gurus.kode_guru', 'gurus.name', 'dudis.kode_dudi', 'dudis.nama_dudi', 'dudis.kuota')
    //                  ->join('praktikans', 'prakerlaps._siswa', '=', 'praktikans.nis')
    //                  ->join('gurus', 'prakerlaps._guru', '=', 'gurus.kode_guru')
    //                  ->join('dudis', 'prakerlaps._dudi', '=', 'dudis.kode_dudi')
    //                  ->get();
    //         $jml = count($results);
    //         if ($results){
    //             return response()->json(['success' => true, "msg" => 'Data Penempatan', 'data' => $results, 'jml' =>$jml], 200);
    //         } else {
    //             return response()->json(['success' => false, 'msg' => 'Data Penempatan Kosong'], 404);
    //         }
    //     }

    public function delete(Request $request, $id)
    {
        $remove = Prakerlap::where('id', $id)->delete();

        if ($remove) {
            return response()->json([
                'success' => true,
                'msg' => 'Prakerlap berhasil dihapus',
                'data' => $remove
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'msg' => 'Prakerlap gagal dihapus',
                'data' => ''
            ], 400);
        }

        // return response()->json(['msg'=>$id]);
    }

    public function getLast(Request $request)
    {
        // $kode = $request->kode;
        $Prakerlap = Prakerlap::orderBy('created_at', 'DESC')->first();

        if ( $Prakerlap ) {
            return response()->json([
                'success' => true,
                'msg' => 'Prakerlap ditemukan',
                'data' => $Prakerlap
            ], 200);
        }
    }



    public function update(Request $request)
    {
        $id = $request->id;
        $Prakerlap = Prakerlap::find($id);

        $Prakerlap->kode_Prakerlap = $request->kode_Prakerlap;
        $Prakerlap->nama_Prakerlap = $request->nama_Prakerlap;
        $Prakerlap->alamat = $request->alamat;
        $Prakerlap->kota = $request->kota;
        $Prakerlap->pemilik = $request->pemilik;
        $Prakerlap->telp = $request->telp;
        $Prakerlap->email = $request->email;
        $Prakerlap->kuota = $request->kuota;

        $update = $Prakerlap->save();

        if ( $update ) {
            return response()->json(["success" => true, "msg" => "Data Prakerlap berhasil diperbarui"], 201);
        } else {
            return response()->json(["success" => false, "msg"=>"Pembaruan data Prakerlap gagal"]);
        }
    } 

    public function regNew(Request $request)
    {
        $datas = $request->all();
        $jml = count($datas);
        $i = 0;

        while($i < $jml) {
            $cek = Prakerlap::where(['_siswa' => $datas[$i]['_siswa']])->count();

            if ($cek > 0) {
                return response()->json(['success' => false, 'msg' => 'Praktikan sudah terdaftar dalam basis data. Mohon konfirmasi ke Super Admin', 'data' => $cek.'-'.$datas[$i]['_siswa']]);
            } else {


                $save = Prakerlap::create([
                    'kode_pkl' =>  $datas [$i]['kode_pkl'],
                    'mutasi' =>  $datas [$i]['mutasi'],
                    'periode' =>  $datas [$i]['periode'],
                    'status' =>  $datas [$i]['status'],
                    '_dudi' =>  $datas [$i]['_dudi'],
                    '_guru' =>  $datas [$i]['_guru'],
                    '_siswa' =>  $datas [$i]['_siswa']
                ], 400);

                $praktikan = Praktikan::where('nis', $datas[$i]['_siswa'])
                                    ->update(['isActive' => '1']);
                
                $i++;
            }

            if ($save) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Calon Praktikan telah terdaftar dan status diaktifkan.',
                    'data' => $save
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Calon Praktikan gagal didaftarkan.',
                    'data' => ''
                ], 401);
            }

        }

        return response()->json(['msg' => $datas]);
    }
}
