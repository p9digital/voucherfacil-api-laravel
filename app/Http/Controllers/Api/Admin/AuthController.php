<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;

class AuthController extends Controller {
  public function login(Request $request) {
    $authorization = $request->header('Authorization');
    $authorizationArray = explode(";", $authorization);
    $credentials = ['email' => $authorizationArray[0], 'password' => $authorizationArray[1]];
    if (Auth::attempt($credentials) === false)
      return response()->json(['message' => 'E-mail ou senha inválidos'], 401);

    // Update user API token
    $user = User::find(Auth::user()->id);
    if (empty($user->token)) {
      $user->token = bcrypt(time());
      $user->save();
    }

    Log::create(["user_id" => $user->id, "log" => "Usuário '$user->name' fez login"]);

    return response()->json([
      'data' => array(
        'marca' => isset($user->cliente) ? $user->cliente->razaoSocial : "Admin",
        'unidade' => isset($user->unidade) ? $user->unidade->nome : "Admin",
        'token' => $user->token,
        'codigo' => isset($user->cliente->promocoes[0]) ? $user->cliente->promocoes[0]->codigo : ""
      )
    ]);
  }

  public function logout(Request $request) {
    $user = $request->user();
    $user->token = null;
    $user->save();

    return response()->json(['message' => 'Logout']);
  }

  public function me(Request $request) {
    $user = $request->user();
    return response()->json([
      'id' => $user->id,
      'cliente_id' => $user->cliente_id,
      'unidade_id' => $user->unidade_id,
      'name' => $user->name,
      'email' => $user->email,
      'tipo' => $user->tipo,
      'status' => $user->status
    ]);
  }

  public function permissions(Request $request) {
    $user = $request->user();
    return response()->json([$user->tipo]);
  }
}
