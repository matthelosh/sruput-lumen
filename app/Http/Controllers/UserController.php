<?php

namespace App\Http\Controllers;
use App\User;
class UserController extends Controller
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

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'success'=> true,
                'message'=> 'user found',
                'data' => $user
            ], 200);
        } else {
             return response()->json([
                'success'=>false,
                'message'=>'User not found',
                'data' => ''
            ], 404);
        }
    }

    public function showAll()
    {
        $users = User::all();
        if ($users) {
            return response()->json([
                'success'=>true,
                'message'=> 'users found',
                'data'=> $users
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=> 'users not found',
                'data'=> ''
            ], 404);
        }
    }
}
