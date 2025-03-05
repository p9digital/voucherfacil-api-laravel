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

    $clientes = Cliente::with('unidades')
      ->where(function ($query) use ($busca) {
        $query->where('razaoSocial', 'like', "%$busca%")->orWhere('nomeFantasia', 'like', "%$busca%");
      })
      ->orderByDesc('created_at');

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
      'path' => 'required|unique:clientes,path'
    ], [
      'required' => 'O campo :attribute é obrigatório.',
      'unique' => 'O campo :attribute do cliente já existe. Cadastre com outro nome.',
      'file' => 'O campo :attribute deve ser um arquivo.'
    ])->validate();

    $cliente = new Cliente($request->all());
    $salvo = $cliente->save();

    $path = storage_path("app/public/" . $cliente->path . "/");
    File::makeDirectory($path, 0777, true, true);

    if ($request->logo) {
      $name = uniqid(date('HisYmd'));
      $extension = $request->file('logo')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $cliente->logo = $nameFile;
      // $request->file('logo')->storeAs("", $nameFile);
      //resize crop image
      $this->resizeCrop($request->file('logo'), $cliente->path, $nameFile, 170, 90);
    }
    if ($request->bannerDesktop) {
      $name = "banner1920";
      $extension = $request->file('bannerDesktop')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      // $cliente->bannerDesktop = $nameFile;
      // $request->file('bannerDesktop')->storeAs("", $nameFile);
      //resize crop image
      $this->resizeCrop($request->file('bannerDesktop'), $cliente->path, $nameFile, 1920, 700);
    }
    if ($request->bannerMobile) {
      $name = "banner750";
      $extension = $request->file('bannerMobile')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      // $cliente->bannerMobile = $nameFile;
      // $request->file('bannerMobile')->storeAs("", $nameFile);
      //resize crop image
      $this->resizeCrop($request->file('bannerMobile'), $cliente->path, $nameFile, 750, 400);
    }

    $salvo = $cliente->save();

    if (!$salvo) {
      Log::error('Cliente NÃO salvo', ['razaoSocial' => $cliente->razaoSocial, 'nomeFantasia' => $cliente->nomeFantasia]);
    }

    return response()->json(['message' => "Cliente salvo com sucesso!", 'data' => $cliente]);
  }

  public function update(Request $request, Cliente $cliente) {
    $validations = [
      'razaoSocial' => 'required',
      'nomeFantasia' => 'required',
      'logo' => 'file',
      'path' => 'required'
    ];
    if ($request->path !== $cliente->path) {
      $validations['path'] = 'required|unique:clientes,path';
    }
    Validator::make($request->all(), $validations, [
      'required' => 'O campo :attribute é obrigatório.',
      'unique' => 'O campo :attribute do cliente já existe. Cadastre com outro nome.',
      'file' => 'O campo :attribute deve ser um arquivo.'
    ])->validate();

    $cliente->fill($request->all());
    if (!empty($request->logo)) {
      $name = uniqid(date('HisYmd'));
      $extension = $request->file('logo')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $cliente->logo = $nameFile;
      $request->file('logo')->storeAs("", $nameFile);
      $this->resizeCrop($request->file('logo'), $cliente->path, $nameFile, 170, 90);
    }
    if ($request->bannerDesktop) {
      $name = "banner1920";
      $extension = $request->file('bannerDesktop')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $this->resizeCrop($request->file('bannerDesktop'), $cliente->path, $nameFile, 1920, 700);
    }
    if ($request->bannerMobile) {
      $name = "banner750";
      $extension = $request->file('bannerMobile')->getClientOriginalExtension();
      $nameFile = "{$name}.{$extension}";
      $this->resizeCrop($request->file('bannerMobile'), $cliente->path, $nameFile, 750, 400);
    }

    $atualizado = $cliente->save();
    if (!$atualizado) {
      Log::error('Cliente NÃO atualizado', ['razaoSocial' => $cliente->razaoSocial, 'nomeFantasia' => $cliente->nomeFantasia]);
    }

    return response()->json(['message' => "Cliente atualizado com sucesso!", 'data' => $cliente]);
  }

  public function remove(Request $request, Cliente $cliente) {
    $user = $request->user();
    if ($user->tipo === 's') {
      $deletado = $cliente->delete();

      if (!$deletado) {
        Log::error('Cliente NÃO deletado', ['nome' => $cliente->nome]);
      }

      return response()->json(['message' => 'Cliente removido com sucesso!']);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }

  private function resizeCrop($image, $path, $nameFile, $width, $height) {
    $manager = new ImageManager(Driver::class);
    $img = $manager->read($image);
    $img->cover($width, $height);
    $img->save(storage_path("app/public/$path/$nameFile"));
    return $nameFile;
  }
}
