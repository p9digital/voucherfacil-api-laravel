<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiGuard;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\ClientesController as AdminClientesController;
use App\Http\Controllers\Api\Admin\CommonController as AdminCommonController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\PromocoesController as AdminPromocoesController;
use App\Http\Controllers\Api\Admin\UnidadesController as AdminUnidadesController;
use App\Http\Controllers\Api\Admin\UsuariosController as AdminUsuariosController;
use App\Http\Controllers\Api\Admin\VouchersController as AdminVouchersController;
use App\Http\Controllers\Api\CidadesController;
use App\Http\Controllers\Api\ContatoController;
use App\Http\Controllers\Api\DestaqueController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\InteresseController;
use App\Http\Controllers\Api\PesquisaController;
use App\Http\Controllers\Api\PromocaoController;
use App\Http\Controllers\Api\VouchersController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// Cidades
Route::prefix('cidades')->controller(CidadesController::class)->group(function () {
  Route::get('/', 'list');
  Route::get('retrieve', 'retrieve');
});

// Contatos
Route::controller(ContatoController::class)->group(function () {
  Route::post('contato', 'store');
  Route::post('contato-empresa', 'storeEmpresa');
});

// Destaques
Route::prefix('destaques')->controller(DestaqueController::class)->group(function () {
  Route::get('/', 'list');
});

// General
Route::prefix('general')->controller(GeneralController::class)->group(function () {
  Route::get('encurtado/{codigo}', 'encurtado');
});

// Interesse
Route::prefix('interesse')->controller(InteresseController::class)->group(function () {
  Route::post('/', 'store');
});

// Pesquisas
Route::prefix('pesquisas')->controller(PesquisaController::class)->group(function () {
  Route::get('{clientePath}/{promocaoPath}', 'retrieve');
});

// Promoções
Route::prefix('promocoes')->controller(PromocaoController::class)->group(function () {
  Route::get('/', 'list');
  Route::get('cidade', 'cidade');
  Route::get('{clientePath}/{promocaoPath}', 'retrieve');
  // Route::post('limite-vouchers', 'quantidadeVouchersDisponiveis');
});

// Vouchers
Route::prefix('vouchers')->controller(VouchersController::class)->group(function () {
  Route::post('/', 'storeVoucher');
  Route::post('pesquisa', 'storeVoucherPesquisa');

  // Promoções
  Route::post('verificaLimitePorEmailOuCelular', 'verificaLimitePorEmailOuCelular');

  // Pesquisas
  Route::post('verificaLimitePorCPFPesquisa', 'verificaLimitePorCPFPesquisa');
});

/**
 * Endpoints do Admin
 */
Route::prefix('admin')->group(function () {
  Route::post('login', [AdminAuthController::class, 'login']);

  // Common routes
  Route::prefix('common')->controller(AdminCommonController::class)->group(function () {
    // Cidades
    Route::prefix('cidades')->group(function () {
      Route::get('/', 'cidades');
    });

    // Estados
    Route::prefix('estados')->group(function () {
      Route::get('/', 'estados');
    });
  });

  // Credentials needed
  Route::middleware([ApiGuard::class])->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::get('me', [AdminAuthController::class, 'me']);
    Route::get('permissions', [AdminAuthController::class, 'permissions']);

    // Dashboard
    Route::prefix('dashboard')->controller(AdminDashboardController::class)->group(function () {
      Route::get('hoje', 'hoje');
      Route::get('ontem', 'ontem');
      Route::get('geral', 'geral');
      Route::get('charts', 'charts');
      Route::get('ultimos30dias', 'ultimos30Dias');
    });

    // Clientes
    Route::prefix('clientes')->controller(AdminClientesController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{cliente}', 'retrieve');
      Route::patch('{cliente}', 'update');
      Route::delete('{cliente}', 'destroy');
    });

    // Promoções
    Route::prefix('promocoes')->controller(AdminPromocoesController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{promocao}', 'retrieve');
      Route::patch('{promocao}', 'update');
      Route::delete('{promocao}', 'destroy');
      Route::post('{promocao}/fotos', 'storeFotos');
      // Promoções unidades
      Route::post('{promocao}/promocao-unidade', 'storePromocaoUnidades');
      Route::post('{promocao}/promocao-unidade/desabilita-dias', 'desabilitaDias');
      Route::delete('{promocao}/promocao-unidade/habilita-dias', 'habilitaDias');
    });

    // Unidades
    Route::prefix('unidades')->controller(AdminUnidadesController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{unidade}', 'retrieve');
      Route::patch('{unidade}', 'update');
      Route::delete('{unidade}', 'destroy');
      // Períodos da unidade
      Route::post('{unidade}/periodos', 'storePeriodos');
      Route::delete('{unidade}/periodos/{periodo}', 'destroyPeriodo');
      // Dias fechados da unidade
      Route::post('{unidade}/dias-fechados', 'storeDiaFechado');
      Route::delete('{unidade}/dias-fechados/{fechado}', 'destroyDiaFechado');
    });

    // Usuários
    Route::prefix('usuarios')->controller(AdminUsuariosController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{usuario}', 'retrieve');
      Route::patch('{usuario}', 'update');
      Route::delete('{usuario}', 'destroy');
    });

    // Vouchers
    Route::prefix('vouchers')->controller(AdminVouchersController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('validar', 'validar');
    });
  });
});
