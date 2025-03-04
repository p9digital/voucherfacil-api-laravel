<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LaravelQRCode\Facades\QRCode;
use App\Models\Lead;
use App\Models\Promocao;
use Throwable;

class HomeController extends Controller {
  public function qrcode($codigo = null) {
    $lead = new Lead();
    if (!empty($codigo)) {
      $lead = Lead::where("voucher", $codigo)->first();
    } else {
      $lead = Lead::all()->last();
    }
    $path = storage_path("app/public/" . $lead->voucher . ".png");
    QRCode::url("https://admin.voucherfacil.com.br/validar/$lead->voucher")->setSize(200)->setOutfile($path)->png();
    return "<img src=\"" . config("app.url") . "/storage/$lead->voucher.png\" />";
  }

  public function filaSms() {
    $hoje = date("Y-m-d");
    Log::info("Enviando SMS $hoje");
    $leads = Lead::where("data_voucher", "<", $hoje)->orderBy("data_voucher", "ASC")->get();
    if ($leads->count() > 0) {
      foreach ($leads as $lead) {
        $dataEnvio = date($lead->data_voucher . " 08:00:00");
        $promocao = Promocao::find($lead->promocao_id);
        try {
          echo "Programando envio do voucher: $lead->voucher às $dataEnvio<br />";
          \App\Jobs\SmsAviso::dispatch($lead, $promocao)->delay($dataEnvio);
        } catch (Throwable $e) {
          Log::error("Erro", [$e]);
          echo "[ERRO] Erro ao enviar SMS do voucher: " . $e->getMessage() . "<br />";
        }
      }
      return "<br />FINALIZADO";
    }
    return "Nenhum lead encontrado";
  }
}
