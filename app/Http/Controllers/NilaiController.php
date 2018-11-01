<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Prakerlap;
use App\Dudi;
use App\Praktikan;
use App\Guru;
use App\Aspeknilai;
use App\Nilai;
class NilaiController extends Controller
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
    public function getHeaderNilai()
    {
        $aspek = Aspeknilai::all();
        if ($aspek){
            return response()->json([
                'success' => true,
                'msg' => 'Aspek Penilaian',
                'data' => $aspek
            ], 200);
        }
    }

    public function addNew(Request $request)
    {
        $cek = Nilai::where(['_siswa' => $request->_siswa])->count();

        if ($cek > 0 ) {
            return response()->json([
                'success' => false,
                'msg' => 'duplicate',
                'data' => ''
            ], 400);
        } else {
            $nilais = $request->input('nilai');

            $save = Nilai::create([
                'kode_nilai' => $request->input('kode_nilai'),
                '_siswa' => $request->input('_siswa'),
                '_dudi' => $request->input('_dudi'),
                'periode' => $request->input('periode'),
                'nilais' => serialize($nilais)
                // 'nt1' => $nilais[0],
                // 'nt2' => $nilais[1],
                // 'nt3' => $nilais[2],
                // 'nt3' => $nilais[3],
                // 'nt3' => $nilais[4],
                // 'nt3' => $nilais[5],
                // 'nt3' => $nilais[6],
                // 'nt3' => $nilais[7],
                // 't1' => $nilais[8],
                // 't2' => $nilais[9],
                // 't3' => $nilais[10],
                // 't4' => $nilais[11],
                // 't5' => $nilais[12],
                // 't6' => $nilais[13],
                // 't7' => $nilais[14],
                // 't8' => $nilais[15],
                // 't9' => $nilais[16],
                // 't10' => $nilais[17]
            ]);


            if ($save) {
                $prakerlap = Prakerlap::where('_siswa', $request->input('_siswa'))
                                    ->update(['scored' => '1']);
                return response()->json([
                    'success'=> true,
                    'msg' => 'Nilai telah ditambahkan',
                    'data' => $save
                ]);
            }
        }
    }

    public function scored (Request $request)
    {
        $periode = $request->periode;
        $results = Nilai::where('nilais.periode', $periode)
                 ->select('nilais.*', 'praktikans.nis', 'praktikans.nama', 'praktikans.kelas','dudis.kode_dudi', 'dudis.nama_dudi')
                 ->join('praktikans', 'nilais._siswa', '=', 'praktikans.nis')
                 ->join('dudis', 'nilais._dudi', '=', 'dudis.kode_dudi')
                 ->get();
        $jml = count($results);
        if ($results){
            // $da = $results->toJson();
            $praktikans = [];
            foreach ($results as $siswa) {
                $nilais = unserialize($siswa->nilais);
                array_push($praktikans, array("kode_nilai" => $siswa->kode_nilai, "nis" => $siswa->nis,"nama" => $siswa->nama, "kelas" => $siswa->kelas,"_dudi" => $siswa->_dudi, "nama_dudi" => $siswa->nama_dudi, "periode" => $siswa->periode, "nilais" => $nilais));
            }


            return response()->json(['success' => true, "msg" => 'Data Nilai', 'data' => $praktikans], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Data Penilaian Kosong'], 404);
        }
    }

    public function updNilai(Request $request, $nis)
    {
        $nilais = $request->all();

        $update = Nilai::where('_siswa',$nis)
                        ->update(['nilais' =>  serialize($nilais)]);

        if ($update){
            return response()->json(['success'=>true, 'msg' => 'Update Nilai Sukses']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Update Nilai Gagal']);
        }
    }

    public function deleteOne(Request $request)
    {
        $hapus = Nilai::where('kode_nilai', $request->kode)->delete();

        if ( $hapus ) {
            // $prakerlap = Prakerlap::where('_siswa', $request->nis)
                        // ->update(["scored" => '0']);
            return response()->json(['success' => true, 'msg'=>'Data Penilaian telah terhapus'], 202);
        } else {
            return response()->json(['success' =>  false, 'msg' => 'Data penilaian, gagal dihapus'], 204);
        }
    }

    public function import(Request $request)
    {
        $datas = $request->all();
        $jml = count($datas);
        $i=0;
        $items= [];
        $th = date('Y');

        while($i < $jml) {
            $kode_nilai = $th.$datas[$i]['periode'].$datas[$i]['_siswa'];
            // $nilais = str_replace(['"', '[', ']'],'',$datas[$i]['nilais']);
            $array_nilai = (explode(",", $datas[$i]['nilais']));
            $nilai = [];
            for($a=0;$a<count($array_nilai);$a++){
                array_push($nilai, $array_nilai[$a]);
            }
            
            $import = Nilai::create([
                'kode_nilai' => $kode_nilai,
                '_siswa' => $datas[$i]['_siswa'],
                '_dudi' => $datas[$i]['_dudi'],
                'nilais' => serialize($nilai),
                'periode' => $datas[$i]['periode'],
            ]);

            $prakerlap = Prakerlap::where('_siswa', $datas[$i]['_siswa'])
                                    ->update(['scored' => '1']);

            array_push($items, $nilai);

            $i++;
        }

        if ($items){
            return response()->json(["success" => true, "msg" => "Import Berhasil", "data" => $items], 202);
        } else {
            return response()->json(["success" => false, "msg" => "Import gagal", "data" => ""], 402);
        }

        
        
    }
}
