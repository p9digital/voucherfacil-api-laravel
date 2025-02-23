<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Cliente;

class ClienteController extends Controller {
	public function retrieve(Request $request, $clientePath) {
		$cliente = Cliente::where("path", $clientePath)->firstOrFail();
		return response()->json(['data' => $cliente], 200);
	}
}
