<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use App\Guru;
use App\Praktikan;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
	public function handle($request, Closure $next, $guard = null)
	{
		$AuthHeader = explode(' ', $request->header('Authorization'));
		$token = $AuthHeader[1];


		if (!$token) {
			return response()->json([
				'error' => 'Token not provided'
			], 401);
		}

		try {
			$credential = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
		}
		catch (ExpiredException $e) {
			return response()->json([
				'error' => 'Token Anda Kadaluwrsa'
			], 400);
		} catch (Exception $e) {
			return response()->json([
				'error' => 'Kesalahan saat membaca token',
				'token' => $token
			]);
		}

		$user = User::where('uname', $credential->sub);

		$request->auth = $user;

		return $next($request);
	}
}