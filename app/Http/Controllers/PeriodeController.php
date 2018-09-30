<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Periode;
class PeriodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function addNew(Request $request)
    {
        $id = $request->input('id');
        $kode = $request->input('kode');
        $periode = $request->input('periode');
        $mulai = $request->input('mulai');
        $selesai = $request->input('selesai');

        $add = Periode::create([
            'id'=>$id,
            'kode'=>$kode,
            'periode'=>$periode,
            'mulai'=>$mulai,
            'selesai'=>$selesai
        ]);

        if ($add) {
            return response()->json([
                'success'=> true,
                'message'=> 'Periode baru ditambahkan',
                'data'=>$add
            ], 201);
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'Periode Gagal ditambahkan',
                'data'=>''
            ], 400);
        }
    }

    public function getAll()
    {
        $periodes = Periode::all();
        if ($periodes) {
            return response()->json([
                'success'=>true,
                'message'=> 'periodes found',
                'data'=> $periodes
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=> 'users not found',
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
