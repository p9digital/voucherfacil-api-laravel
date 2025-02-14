<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Lead;
use App\Models\Promocao;

class LeadsExport implements FromCollection {

  public function collection() {
    $user = Auth::user();
    $leads = Lead::selectRaw("(SELECT nome FROM unidades WHERE id = leads.unidade_id) AS unidade, (SELECT titulo FROM promocoes WHERE id = leads.promocao_id) AS promocao, nome, email, telefone, voucher, data_voucher, (SELECT nome FROM periodos WHERE id = leads.periodo_id) AS periodo, device, validado, created_at, (SELECT pesquisas FROM pesquisas WHERE lead_id = leads.id) AS pesquisas, (SELECT respostas FROM pesquisas WHERE lead_id = leads.id) AS respostas")->whereNotNull("data_voucher");
    if (!empty($user->cliente_id) && $user->tipo == "a") {
      $promocoes = Promocao::select("id")->where("cliente_id", $user->cliente_id)->pluck("id")->toArray();
      $leads = $leads->whereIn("promocao_id", $promocoes);
    } else if (!empty($user->cliente_id) && $user->tipo == "f") {
      $leads = $leads->where("unidade_id", $user->unidade_id);
    }
    $leads = $leads->get();
    $leads = collect($leads);
    $leads = $leads->map(function ($lead) {
      $lead->validado = $lead->validado == "1" ? "Sim" : "Não";
      $pesquisas = json_decode($lead->pesquisas);
      $respostas = (array) json_decode($lead->respostas);
      $listaPesquisas = "";
      foreach ($pesquisas as $pesquisa) {
        $listaPesquisas .= $pesquisa->id . ": " . $pesquisa->pergunta . "\n";
      }
      $listaRespostas = "";
      for ($i = 0; $i < count($pesquisas); $i++) {
        if (isset($respostas[$i])) {
          $listaRespostas .= ($i + 1) . ": " . $respostas[$i] . "\n";
        }
      }

      $lead->pesquisas = $listaPesquisas;
      $lead->respostas = $listaRespostas;
      return $lead;
    });
    $leads->prepend(collect([
      'unidade' => 'Unidade',
      'promocao' => 'Promoção',
      'nome' => 'Nome',
      'email' => 'E-mail',
      'telefone' => 'Telefone',
      'voucher' => 'Voucher',
      'data_voucher' => 'Data Agendamento',
      'periodo' => 'Período',
      'device' => 'Dispositivo',
      'validado' => 'Validado',
      'created_at' => 'Data Cadastro',
      'pesquisas' => 'Pesquisas',
      'respostas' => 'Respostas'
    ]));
    return $leads;
  }
}
