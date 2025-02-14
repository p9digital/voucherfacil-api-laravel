<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller {
    public function __construct() {
    }

    /**
     * testa se um token esta ok ao retornar o user autenticado
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function whoami(Request $request) {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }


    /**
     * retorna objeto com o token e as infos do auth
     *
     * @param  string $token
     * @param  object $user
     *
     * @return void
     */
    protected function respondWithToken($token, $user) {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 10000 * 60,
            'data' => $user
        ]);
    }

    /**
     * login via jwt
     *
     * @param  Request $request
     *
     * @return function
     */
    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $user = User::where('id', auth('api')->user()->id)->first();

        return $this->respondWithToken($token, $user);
    }

    /**
     * logout via jwt - invalida um token
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function logout(Request $request) {
        // $this->validate($request, ['token' => 'required']);
        try {
            // JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message' => "Logout feito"]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Erro no logout'], 500);
        }
    }
}
