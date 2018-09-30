<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jadwal;
class JadwalController extends Controller
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

    public function addNew(Request $request)
    {
        $start = strtotime('12:00am '.$request->input('start'));
        $end = strtotime('11:59pm '.$request->input('end'));
        $kegiatan = $request->input('kegiatan');
        $pelaksana = $request->input('pelaksana');
        $tempat = $request->input('tempat');
        $periode = $request->input('periode');

        $add = Jadwal::create([
            'start' => date('Y-m-d h:i:sa', $start),
            'end' => date('Y-m-d h:i:sa', $end),
            'kegiatan' => $kegiatan,
            'pelaksana' => $pelaksana,
            'tempat' => $tempat,
            'periode' => $periode
        ]);

        if ($add) {
            return response()->json([
                'success'=> true,
                'message'=> 'Jadwal baru ditambahkan',
                'data'=>$add
            ], 201);
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'Jadwal Gagal ditambahkan',
                'data'=>''
            ], 400);
        }
    }

    public function getAll(Request $request)

    {
        $periode = $request->periode;
        // return response()->json(['msg'=>$periode]);
        $jadwals = Jadwal::where('periode', $periode)->get();
        if ($jadwals) {
            return response()->json([
                'success'=>true,
                'message'=> 'Jadwal found',
                'data'=> $jadwals
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=> 'Jadwal not found',
                'data'=> ''
            ], 404);
        }
    }
    
    // public function deleteOne($id)
    // {
    //     $periode = Periode::forceDelete('id', $id);

    //     if ($periode) {
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>'Periode dihapus',
    //             'data'=>$periode
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>'Periode gagal dihapus',
    //             'data'=>''
    //         ]);
    //     }
    // }


}
