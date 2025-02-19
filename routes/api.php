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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
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
