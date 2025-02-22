<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Promocao;
use App\Models\PromocaoUnidade;
use Throwable;

class PromocoesController extends Controller {
  public function list(Request $request) {
    $user = $request->user();

    $promocoes = Promocao::with('cliente', 'cidades');
    if ($user->tipo === 'a') {
      $promocoes = $promocoes->where("cliente_id", $user->cliente_id);
    } else if ($user->tipo === 'f') {
      $promocoes = $promocoes->whereHas('promocaounidades', function ($query) use ($user) {
        $query->where("cliente_id", $user->cliente_id)->where("unidade_id", $user->unidade_id);
      });
    }
    if ($request->cliente_id) {
      $promocoes = $promocoes->where("cliente_id", $request->cliente_id);
    }

    return response()->json(['data' => $promocoes->get()], 200);
  }

  public function retrieve(Request $request, Promocao $promocao) {
    $user = $request->user();
    if (
      ($user->tipo === 'f')
      || ($user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
    )
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $promocao->with('promocaounidades.unidade', 'promocaounidades.periodos', 'fotos')->first()]);
  }

  public function store(Request $request) {
    Validator::make($request->all(), [
      'cliente_id' => 'required',
      'titulo' => 'required',
      'path' => 'required',
      'valor' => 'required',
      'codigo' => 'required',
      'dataInicio' => 'required',
      'dataFim' => 'required',
      'dataPublicacao' => 'required',
    ], [
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $promocao = new Promocao($request->all());

    if (!$promocao->save()) {
      Log::error('Promoção NÃO cadastrada', ['titulo' => $promocao->titulo]);
    }

    return response()->json(['message' => "Promoção cadastrada com sucesso!", 'data' => $promocao]);
  }

  public function update(Request $request, Promocao $promocao) {
    Validator::make($request->all(), [
      'cliente_id' => 'required',
      'titulo' => 'required',
      'path' => 'required',
      'valor' => 'required',
      'codigo' => 'required',
      'dataInicio' => 'required',
      'dataFim' => 'required',
      'dataPublicacao' => 'required',
    ], [
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $promocao->fill($request->all());

    if (!$promocao->save()) {
      Log::error('Unidade NÃO atualizada', ['titulo' => $promocao->titulo]);
    }

    return response()->json(['message' => "Promoção atualizada com sucesso!", 'data' => $promocao]);
  }

  public function storePromocaoUnidades(Request $request, Promocao $promocao) {
    $user = $request->user();

    if ($user->tipo === 'f' || $user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
      return response()->json(['error' => 'Unauthorized'], 401);

    // Delete promoção unidades
    $promocaounidadesRemovidas = $promocao->promocaounidades()->whereNotIn('unidade_id', $request->unidades)->get();
    foreach ($promocaounidadesRemovidas as $promocaounidadeRemovida) {
      $promocaounidadeRemovida->periodos()->delete();
      $promocaounidadeRemovida->delete();
    }

    // Vincula promoção unidades
    foreach ($request->unidades as $unidade) {
      $atualizarPromocaoUnidade =  PromocaoUnidade::where(['promocao_id' => $promocao->id, 'unidade_id' => $unidade])->first();
      if (!$atualizarPromocaoUnidade) {
        PromocaoUnidade::create(['promocao_id' => $promocao->id, 'unidade_id' => $unidade]);
      }
    }

    return response()->json(['message' => "Promoção cadastradas salva com sucesso!", 'data' => $promocao]);
  }

  public function storeFotos(Request $request, Promocao $promocao) {
    $user = $request->user();

    if ($user->tipo === 'f' || $user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
      return response()->json(['error' => 'Unauthorized'], 401);

    // $promocao->fotos()
    $promocaoUrl = $promocao->cliente->path . "/" . $promocao->path . "/";

    try {
      if ($request->bannerDesktopXl) {
        $name = "banner-1920x700";
        Log::info("Upload imagem: $name");
        $fileBannerDesktopXl = $request->file('bannerDesktopXl');
        $extension = $fileBannerDesktopXl->getClientOriginalExtension();
        $nameFile = "{$name}.{$extension}";
        // $fileBannerDesktopXl->storeAs("", $nameFile);
        //resize crop image
        $this->resizeCrop($fileBannerDesktopXl, $promocaoUrl, $nameFile, $extension, 1920, 700);
      }
      if ($request->bannerDesktop) {
        $name = "banner-1100x600";
        Log::info("Upload imagem: $name");
        $fileBannerDesktop = $request->file('bannerDesktop');
        $extension = $fileBannerDesktop->getClientOriginalExtension();
        $nameFile = "{$name}.{$extension}";
        // $fileBannerDesktop->storeAs("", $nameFile);
        //resize crop image
        $this->resizeCrop($fileBannerDesktop, $promocaoUrl, $nameFile, $extension, 1100, 600);
      }
      if ($request->bannerMobile) {
        $name = "banner-750x420";
        Log::info("Upload imagem: $name");
        $fileBannerMobile = $request->file('bannerMobile');
        $extension = $fileBannerMobile->getClientOriginalExtension();
        $nameFile = "{$name}.{$extension}";
        // $fileBannerMobile->storeAs("", $nameFile);
        //resize crop image
        $this->resizeCrop($fileBannerMobile, $promocaoUrl, $nameFile, $extension, 750, 420);
      }

      if (!$request->foto_id) {
        $foto = new Foto([
          'promocao_id' => $promocao->id,
          'arquivo' => $promocaoUrl . "banner-1920x700",
          'foto_desk_xl' => $promocaoUrl . "banner-1920x700",
          'foto_desk' => $promocaoUrl . "banner-1100x600",
          'foto_card' => $promocaoUrl . "banner-750x420",
          'foto_mob' => $promocaoUrl . "banner-750x420",
          'foto_mob_xs' => $promocaoUrl . "banner-750x420",
        ]);
        if (!$foto->save()) {
          Log::error('Fotos NÃO atualizadas', ['titulo' => $promocao->titulo]);
        }
      }
    } catch (Throwable $e) {
      Log::error('Erro ao fazer upload das fotos', [$e->getMessage()]);
    }

    $path = storage_path("app/public/" . $promocao->cliente->path . "/" . $promocao->path);
    File::makeDirectory($path, $mode = 0777, true, true);

    return response()->json(['message' => "Fotos cadastradas com sucesso!", 'data' => $promocao]);
  }

  private function resizeCrop($image, $promocaoUrl, $nameFile, $extension, $width, $height) {
    $manager = new ImageManager(Driver::class);
    $img = $manager->read($image);
    $dim = (intval($img->width()) / intval($img->height())) - ($width / $height);

    if ($dim > 0) {
      $img->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      if ($extension == "png") {
        $img->resize($width, null, 'center', true, 'rgba(0, 0, 0, 0)');
      } else {
        $img->resize($width, null, 'center', true, 'ffffff');
      }
    } else {
      $img->resize(null, $height, function ($constraint) {
        $constraint->aspectRatio();
      });

      if ($extension == "png") {
        $img->resize(null, $height, 'center', true, 'rgba(0, 0, 0, 0)');
      } else {
        $img->resize(null, $height, 'center', true, 'ffffff');
      }
    }
    $img->crop($width, $height);
    $img->save(storage_path('app/public/' . $promocaoUrl . $nameFile));
    return $nameFile;
  }
}
