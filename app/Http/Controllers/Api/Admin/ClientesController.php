<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Controller;
use App\Models\Cliente;

class ClientesController extends Controller {
  public function list(Request $request) {
    $user = $request->user();
    if ($user->tipo !== 's')
      return response()->json(['error' => 'Unauthorized'], 401);

    $busca = $request->busca ? $request->busca : '';
    $page = $request->page ? $request->page : 1;
    $page_size = $request->page_size ? $request->page_size : 100;
    $skip = ($page - 1) * $page_size;

    $clientes = Cliente::where(function ($query) use ($busca) {
      $query->where('razaoSocial', 'like', "%$busca%")->orWhere('nomeFantasia', 'like', "%$busca%");
    })->orderByDesc('created_at');

    return response()->json([
      'count' => $clientes->count(),
      'data' => $request->all ? $clientes->get() : $clientes->skip($skip)->take($page_size)->get()
    ]);
  }

  public function retrieve(Request $request, Cliente $cliente) {
    $user = $request->user();

    if ($user->tipo !== 's')
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $cliente]);
  }

  public function store(Request $request) {
    Validator::make($request->all(), [
      'razaoSocial' => 'required',
      'nomeFantasia' => 'required',
      'logo' => 'file',
      'path' => 'required'
    ], [
      'required' => 'O campo :attribute é obrigatório.',
      'file' => 'O campo :attribute deve ser um arquivo.'
    ])->validate();

    $cliente = new Cliente($request->all());

    if ($request->logo) {
      $name = uniqid(date('HisYmd'));
      $extension = $request->file('logo')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $cliente->logo = $nameFile;
      $request->file('logo')->storeAs("", $nameFile);
      //resize crop image
      $cliente->logo = $this->resizeCrop($request->file('logo'));
    }

    $salvo = $cliente->save();

    $path = storage_path("app/public/" . $cliente->path . "/");
    File::makeDirectory($path, $mode = 0777, true, true);

    if (!$salvo) {
      Log::error('Cliente NÃO salvo', ['razaoSocial' => $cliente->razaoSocial, 'nomeFantasia' => $cliente->nomeFantasia]);
    }

    return response()->json(['message' => "Cliente salvo com sucesso!", 'data' => $cliente]);
  }

  public function update(Request $request, Cliente $cliente) {
    Validator::make($request->all(), [
      'razaoSocial' => 'required',
      'nomeFantasia' => 'required',
      'logo' => 'file',
      'path' => 'required'
    ], [
      'required' => 'O campo :attribute é obrigatório.',
      'file' => 'O campo :attribute deve ser um arquivo.'
    ])->validate();

    $cliente->fill($request->all());
    if (!empty($request->logo)) {
      $name = uniqid(date('HisYmd'));
      $extension = $request->file('logo')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $request->file('logo')->storeAs("", $nameFile);
      //resize crop image
      $cliente->logo = $this->resizeCrop($request->file('logo'));
    }

    $atualizado = $cliente->save();
    if (!$atualizado) {
      Log::error('Cliente NÃO atualizado', ['razaoSocial' => $cliente->razaoSocial, 'nomeFantasia' => $cliente->nomeFantasia]);
    }

    return response()->json(['message' => "Cliente atualizado com sucesso!", 'data' => $cliente]);
  }

  public function destroy(Request $request, Cliente $cliente) {
    $user = $request->user();
    if ($user->tipo === 's') {
      $deletado = $cliente->delete();

      if (!$deletado) {
        Log::error('Cliente NÃO deletado', ['nome' => $cliente->nome]);
      }

      return response()->json(['message' => 'Cliente removido com sucesso!'], 200);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }

  private function resizeCrop($image) {
    $name = uniqid(date('HisYmd'));
    $extension = $image->getClientOriginalExtension();
    $nameFile = "{$name}.{$extension}";

    $manager = new ImageManager(Driver::class);
    $img = $manager->read($image);
    $dim = (intval($img->width()) / intval($img->height())) - (170 / 90);

    if ($dim > 0) {
      $img->resize(170, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      if ($extension == "png") {
        $img->resize(170, null, 'center', true, 'rgba(0, 0, 0, 0)');
      } else {
        $img->resize(170, null, 'center', true, 'ffffff');
      }
    } else {
      $img->resize(null, 90, function ($constraint) {
        $constraint->aspectRatio();
      });

      if ($extension == "png") {
        $img->resize(null, 90, 'center', true, 'rgba(0, 0, 0, 0)');
      } else {
        $img->resize(null, 90, 'center', true, 'ffffff');
      }
    }
    $img->crop(170, 90);
    $img->save(storage_path('app/public/' . $nameFile));
    return $nameFile;
  }
}
