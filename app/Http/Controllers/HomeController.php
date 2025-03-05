<?php

namespace App\Http\Controllers;

use LaravelQRCode\Facades\QRCode;
use App\Models\Lead;

class HomeController extends Controller {
  public function qrcode($codigo = null) {
    $lead = Lead::all()->last();
    if (!empty($codigo)) {
      $lead = Lead::where("voucher", $codigo)->first();
    }
    $path = storage_path("app/public/" . $lead->voucher . ".png");
    QRCode::url(env("ADMIN_URL") . "/validar/$lead->voucher")->setSize(200)->setOutfile($path)->png();
    return "<img src=\"" . config("app.url") . "/storage/$lead->voucher.png\" />";
  }
}
