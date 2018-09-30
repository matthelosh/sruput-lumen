<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Guru;
use App\Praktikan;
class ProfileController extends Controller
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

    public function getProfile(Request $request, $id, $role)
        {
            
            // if ( $role === '1') 
            // {
            //     return response()->json([
            //         // 'uname' => $id,
            //         'role' => 'Admin'
            //     ]);
            // } else if ( $role === '2' )
            // {
            //      return response()->json([
            //         // 'uname' => $id,
            //         'role' => 'Guru'
            //     ]);
            // } else if ( $role === '3' )
            // {
            //      return response()->json([
            //         // 'uname' => $id,
            //         'role' => 'Praktikan'
            //     ]);
            // }
            // $user;
            if ( $role === '1' ) {
                $user = User::where('uname', $id)->first();
                // return response()->json([
                //     'msg' => $user,
                //     'id' => $id
                // ]);
            } else if ($role === '2') {
                $user = Guru::where('uname', $id)->first();
            } else if ($role === '3' ) {
                $user = Praktikan::where('uname', $id)->first();
            }

            if ( $user ) {
                return response()->json([
                    'success' => true, 
                    'message' => 'User ditemukan',
                    'data'=> $user
                ], 200);
            } else {
                return response()->json([
                    'success' => true, 
                    'message' => 'User tidak ditemukan',
                    'data'=> $role
                ], 404);
            }
        }
    // public function addNew(Request $request)
    // {
    //     // $id = $request->input('id');
    //     $icon = $request->input('icon');
    //     $title = $request->input('title');
    //     $role = $request->input('role');
    //     $linkTo = $request->input('linkTo');

    //     $add = Menu::create([
    //         // 'id'=>$id,
    //         'icon'=>$icon,
    //         'title'=>$title,
    //         'role'=>$role,
    //         'linkTo'=>$linkTo
    //     ]);

    //     if ($add) {
    //         return response()->json([
    //             'success'=> true,
    //             'message'=> 'Menu baru ditambahkan',
    //             'data'=>$add
    //         ], 201);
    //     } else {
    //         return response()->json([
    //             'success'=> false,
    //             'message'=> 'Menu Gagal ditambahkan',
    //             'data'=>''
    //         ], 400);
    //     }
    // }

    // public function getMenu(Request $request, $role)
    // {
    //     $menus = Menu::where('role', $role)->get();
    //     if ($menus) {
    //         return response()->json([
    //             'success'=>true,
    //             'role' => $role,
    //             'message'=> 'menus found',
    //             'data'=> $menus
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'success'=>false,
    //             'message'=> 'menus not found',
    //             'data'=> ''
    //         ], 404);
    //     }
    // }
    
    // // public function deleteOne($id)
    // // {
    // //     $periode = Periode::forceDelete('id', $id);

    // //     if ($periode) {
    // //         return response()->json([
    // //             'success'=>true,
    // //             'message'=>'Periode dihapus',
    // //             'data'=>$periode
    // //         ]);
    // //     } else {
    // //         return response()->json([
    // //             'success'=>false,
    // //             'message'=>'Periode gagal dihapus',
    // //             'data'=>''
    // //         ]);
    // //     }
    // // }


}
