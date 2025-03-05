<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Throwable;

class UsuariosController extends Controller {
  // permissions: super, admin
  public function list(Request $request) {
    $user = $request->user();
    if ($user->tipo !== 's' && $user->tipo !== 'a')
      return response()->json(['error' => 'Unauthorized'], 401);

    $busca = $request->busca ? $request->busca : '';
    $page = $request->pagina ? $request->pagina : 1;
    $page_size = $request->page_size ? $request->page_size : 20;
    $skip = ($page - 1) * $page_size;

    $usuarios = User::with('cliente', 'unidade')->where('id', '<>', $user->id)->where(function ($query) use ($busca) {
      $query->where('name', 'like', "%$busca%")->orWhere('email', 'like', "%$busca%");
    });
    if ($user->tipo === 'a') {
      $usuarios = $usuarios->whereNot('tipo', 's')->where('cliente_id', $user->cliente_id);
    }
    $usuarios = $usuarios->orderByDesc('created_at');

    return response()->json([
      'count' => $usuarios->count(),
      'data' => $request->all ? $usuarios->get() : $usuarios->skip($skip)->take($page_size)->get()
    ]);
  }

  // permissions: super, admin, franq
  public function retrieve(Request $request, User $usuario) {
    $user = $request->user();
    if (
      ($user->tipo === 'a' && ($usuario->tipo === 's' || $user->cliente_id !== $usuario->cliente_id))
      || ($user->tipo === 'f' && $user->id !== $usuario->id)
    )
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $usuario]);
  }

  // permissions: super, admin
  public function store(Request $request) {
    $user = $request->user();
    Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'confirmed',
    ], [
      'email' => 'E-mail inválido.',
      'file' => 'O campo :attribute deve ser um arquivo.',
      'required' => 'O campo :attribute é obrigatório.',
      'unique' => 'E-mail já usado.'
    ])->validate();

    $usuario = new User($request->all());
    if ($user->tipo === 'a') {
      $usuario->cliente_id = $user->cliente_id;
    }
    $salvo = $usuario->save();

    if (!$salvo) {
      Log::error('Usuário NÃO salvo', ['name' => $usuario->name, 'email' => $usuario->email]);
    }

    return response()->json(['message' => "Usuário salvo com sucesso!", 'data' => $usuario]);
  }

  // permissions: super, admin, franq
  public function update(Request $request, User $usuario) {
    Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'confirmed',
      'tipo' => 'required',
    ], [
      'email' => 'E-mail inválido.',
      'file' => 'O campo :attribute deve ser um arquivo.',
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $usuario->fill($request->all());
    $senha = $request->input('password');
    if (empty($senha)) {
      unset($usuario->password);
    }
    $atualizado = $usuario->save();

    if (!$atualizado) {
      Log::error('Usuário NÃO atualizado', ['name' => $usuario->name, 'email' => $usuario->email]);
    }

    return response()->json(['message' => "Usuário atualizado com sucesso!", 'data' => $usuario]);
  }

  public function remove(Request $request, User $usuario) {
    $user = $request->user();
    if ($user->id === $usuario->id)
      return response()->json(['error' => 'Unauthorized'], 401);

    try {
      $deletado = $usuario->delete();

      if (!$deletado) {
        Log::error('Usuário NÃO deletado', ['nome' => $usuario->nome]);
      }

      return response()->json(['message' => 'Usuário removido com sucesso!']);
    } catch (Throwable $e) {
      Log::error('Erro ao deletar usuário', [$e->getMessage()]);
    }
  }
}
