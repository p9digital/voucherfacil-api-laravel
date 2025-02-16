<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\ClientesController as AdminClientesController;
use App\Http\Controllers\Api\Admin\CommonController as AdminCommonController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\UnidadesController as AdminUnidadesController;
use App\Http\Controllers\Api\Admin\UsuariosController as AdminUsuariosController;
use App\Http\Controllers\Api\Admin\VouchersController as AdminVouchersController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContatoController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DestaqueController;
use App\Http\Controllers\Api\InteresseController;
use App\Http\Controllers\Api\LocaisController;
use App\Http\Controllers\Api\PesquisaController;
use App\Http\Controllers\Api\PromocaoController;
use App\Http\Controllers\Api\UnidadesController;
use App\Http\Controllers\Api\VouchersController;
use App\Http\Middleware\ApiGuard;

// Endpoints para Agendamento
Route::post('voucher', [VouchersController::class, 'storeVoucher']);
Route::post('voucherPesquisa', [VouchersController::class, 'storeVoucherPesquisa']);
Route::post('interesse', [InteresseController::class, 'store']);

Route::post('users/login', [AuthController::class, 'login']);
Route::post('users/whoami', [AuthController::class, 'whoami']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
  Route::post('hoje', 'hoje');
  Route::post('ontem', 'ontem');
  Route::post('mesAtual', 'mesAtual');
  Route::post('mesAnterior', 'mesAnterior');
  Route::post('geral', 'geral');
  Route::post('grafico', 'grafico');
  Route::post('ultimos30dias', 'ultimos30Dias');
  Route::post('promos', 'promos');
});

Route::post('login', [UnidadesController::class, 'login']);

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

Route::get('locais/{uf}/cidades/todas', [LocaisController::class, 'buscaCidadesPorEstado']);

/**
 * Api's do Novo Front-End
 */

// Endpoint que retorna cidades com promoções
Route::get('promocoes/cidades', [LocaisController::class, 'cidadesPromocoes']);

Route::controller(PromocaoController::class)->group(function () {
  // Endpoint que retorna cidades com promoções
  Route::post('promocao/limite-vouchers', 'atualizaLimiteDeVouchers');
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
  Route::post('contato', 'storeContato');
  Route::post('contatoempresa', 'storeEmpresa');
});

Route::prefix('pesquisa')->group(function () {
  Route::get('{clientepath}/{promocaopath}', [PesquisaController::class, 'pesquisa']);
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
      Route::get('promos', 'promos');
    });

    // Clientes
    Route::prefix('clientes')->controller(AdminClientesController::class)->group(function () {
      Route::get('/', 'list');
      Route::post('/', 'store');
      Route::get('{cliente}', 'retrieve');
      Route::patch('{cliente}', 'update');
      Route::delete('{cliente}', 'destroy');
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
