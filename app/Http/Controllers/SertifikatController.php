<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sertifikat;
class SertifikatController extends Controller
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
        // $id = $request->input('id');
        $icon = $request->input('icon');
        $title = $request->input('title');
        $role = $request->input('role');
        $linkTo = $request->input('linkTo');

        $add = Menu::create([
            // 'id'=>$id,
            'icon'=>$icon,
            'title'=>$title,
            'role'=>$role,
            'linkTo'=>$linkTo
        ]);

        if ($add) {
            return response()->json([
                'success'=> true,
                'message'=> 'Menu baru ditambahkan',
                'data'=>$add
            ], 201);
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'Menu Gagal ditambahkan',
                'data'=>''
            ], 400);
        }
    }

    public function getLast(Request $request)
    {
        $cek = Sertifikat::where('periode', $request->periode)->count();

        if ($cek > 0){

            $sertifikat = Sertifikat::where('periode', $request->periode)->orderBy('no_surat', 'desc')->first();

            if ($sertifikat) {
                return response()->json([
                    'success' => true,
                    'msg' => 'No Surat Terakhir',
                    'data' => $sertifikat
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No Surat Terakhir',
                    'data' => '0'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => true,
                'msg' => 'Belum ada data No sertifikat',
                'data' => '0'
            ], 200);
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
