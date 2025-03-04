<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\ClientesController as AdminClientesController;
use App\Http\Controllers\Api\Admin\CommonController as AdminCommonController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\PromocoesController as AdminPromocoesController;
use App\Http\Controllers\Api\Admin\UnidadesController as AdminUnidadesController;
use App\Http\Controllers\Api\Admin\UsuariosController as AdminUsuariosController;
use App\Http\Controllers\Api\Admin\VouchersController as AdminVouchersController;
use App\Http\Controllers\Api\ContatoController;
use App\Http\Controllers\Api\DestaqueController;
use App\Http\Controllers\Api\InteresseController;
use App\Http\Controllers\Api\PromocaoController;
use App\Http\Controllers\Api\VouchersController;
use App\Http\Middleware\ApiGuard;

// Endpoints para Agendamento
Route::post('voucher', [VouchersController::class, 'storeVoucher']);
Route::post('voucherPesquisa', [VouchersController::class, 'storeVoucherPesquisa']);
Route::post('interesse', [InteresseController::class, 'store']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::controller(VouchersController::class)->group(function () {
  Route::post('leads', 'leads');

  Route::prefix('vouchers')->group(function () {
    Route::post('/', 'vouchers');
    Route::post('detalhes', 'vouchersDetalhes');
    Route::post('validar', 'validar');
    Route::post('verificaLimitePorEmailOuCelular', 'verificaLimitePorEmailOuCelular');
    Route::post('verificaLimitePorCPFPesquisa', 'verificaLimitePorCPFPesquisa');
  });
});

/**
 * Api's do Novo Front-End
 */

Route::controller(PromocaoController::class)->group(function () {
  // Endpoint que retorna cidades com promoções
  Route::post('promocao/limite-vouchers', 'quantidadeVouchersDisponiveis');
  // Endpoints que retornam promoções
  Route::get('promocoes/todas', 'todas');
  Route::get('estados/{uf}/cidades/{path}/promocoes', 'promocoesPorCidades');
  Route::get('clientes/{path}/promocoes', 'promocoesPorClientes');
  Route::get('clientes/{clientePath}/cidade/{cidadePath}/promocoes', 'promocoesPorClientesECidade');

  // Endpoints que retornam um promoção
  Route::get('clientes/{clientepath}/promocoes/{promocaopath}', 'promocao');
});

/**
 * Endpoints para destaques (banners)
 */
Route::controller(DestaqueController::class)->group(function () {
  Route::get('destaques/todos', 'todos');
  Route::get('estados/{uf}/cidades/{path}/destaques', 'porCidade');
  Route::get('clientes/{path}/destaques', 'porCliente');
});

/**
 * Endpoints para Contato
 */
Route::controller(ContatoController::class)->group(function () {
  Route::post('contato', 'store');
  Route::post('contatoempresa', 'storeEmpresa');
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
      Route::get('mesAtual', 'mesAtual');
      Route::get('mesAnterior', 'mesAnterior');
      Route::get('geral', 'geral');
      Route::get('grafico', 'grafico');
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
    });

    // Unidades
    Route::prefix('unidades')->controller(AdminUnidadesController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{unidade}', 'retrieve');
      Route::patch('{unidade}', 'update');
      Route::delete('{unidade}', 'destroy');
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
