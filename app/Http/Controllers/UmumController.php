<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Kelas;

class UmumController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getKelases()
    {
        $kelas = Kelas::all();

        if ( $kelas ) {
            return response()->json([
                'success' => true,
                'msg' => 'Data Kelas',
                'data' => $kelas
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Zonk',
                'data' => ''
            ], 404);
        }
    }
}
