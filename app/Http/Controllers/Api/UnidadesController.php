<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;

class UnidadesController extends Controller {
    public function login(Request $request) {
        //apiLogin eh um helper
        $user = User::where('email', $request->email)->first();
        if (isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password) && $user) {
            $auth = Hash::check($request->password, $user->password);
            if ($auth) {
                if (empty($user->token)) {
                    $user->token = bcrypt(time());
                    $user->save();
                }

                return response()->json([
                    'success' => true,
                    'data' => array(
                        'marca' => isset($user->cliente) ? $user->cliente->razaoSocial : "Admin",
                        'unidade' => isset($user->unidade) ? $user->unidade->nome : "Admin",
                        'token' => $user->token,
                        'codigo' => isset($user->cliente->promocoes[0]) ? $user->cliente->promocoes[0]->codigo : ""
                    )
                ], 200);
            }
        }

        return response()->json(['success' => false, 'error' => 'sem autorizacao'], 500);
    }
}
