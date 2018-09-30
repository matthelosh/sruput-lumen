<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Praktikan;
use App\Guru;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $uname = $request->input('uname');
        // $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $keyReg = $uname[0];

        // return response()->json([
        //     'success' => true,
        //     'message' => $keyReg
        // ]);
        // Check Calon User
        if ($keyReg === '@') {
            $register = User::create([
                'uname' => $uname,
                'name' => $request->input('name'),
                'email'=>$email,
                'password'=>$password,
                '_role' => '1'
            ]);
        } else if ($keyReg === 'u') {
            $register = Praktikan::create([
                'uname' => $uname,
                'password'=>$password,
                'nis' => $request->input('nis'),
                'nama' => $request->input('nama'),
                'kelas' => $request->input('kelas'),
                'periode' => $request->input('periode'),
                'hp' => $request->input('hp'),
                'hp_ortu' => $request->input('hp_ortu'),
                'alamat' => $request->input('alamat'),
                '_role' => '3',
                'isActive' => '1'
            ]);
        } else {
            $register = Guru::create([
                'kode_guru' => $request->input('kode_guru'),
                'uname' => $uname,
                'password' => $password,
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'hp' => $request->input('hp'),
                '_role' => '2',
                'isActive' => '1'
            ]);
        }

        

        if ($register) {
            return response()->json([
                'success'=> true,
                'message'=> 'Register Success',
                'data'=>$register
            ], 201);
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'Register Gagal',
                'data'=>''
            ], 400);
        }
    }

    private function jwt($user)
    {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->uname,
            'iat' => time(),
            'exp' => time() + 60*60
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function login(Request $request)
    {
        $uname = $request->input('uname');
        // $email = $request->input('email');
        $password = $request->input('password');

        // $Schema;\
        $keyLogin = $uname[0];

        if ($keyLogin === '@' ) {
            
            $user = User::where('uname', $uname)->first();
            
        } else if ($keyLogin === 'u') {
            $user = Praktikan::where('uname', $uname)->first();
        } else {
            $user = Guru::where('uname', $uname)->first();
        }


        if(!$user) {
            return response()->json([
                'success'=>false,
                'message'=>'User not found',
                'data' => ''
            ], 404);
        } //else {
        //     $pass = Hash::make($password);
        //     return response()->json([
        //         'success' => true,
        //         'message' => $pass
        //     ]);
        // }

        if (Hash::check($password, $user->password)) {
            $apiToken = $this->jwt($user);

            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'Login berhasil',
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'Login gagal',
                'data' => ''
            ], 403);
        }
    }


}
