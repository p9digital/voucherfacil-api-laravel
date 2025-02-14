<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    Route::get('/{clientepath}/{promocaopath}', [PesquisaController::class, 'pesquisa']);
});
