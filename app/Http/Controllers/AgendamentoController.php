<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Lead;
use App\Models\Promocao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AgendamentoController extends Controller {

    public function index(Request $request) {
        $lead = new Lead($request->all());
        $data_voucher = explode("/", $lead->data_voucher);
        $lead->data_voucher = $data_voucher[2] . "-" . $data_voucher[1] . "-" . $data_voucher[0];
        $diasMais = date_create('+21 day')->format('Y-m-d');
        $cli = $lead->promocao->cliente;
        $promo = $lead->promocao;
        $desabilitados = $promo->promocaounidades->where('unidade_id', $lead->unidade_id)->first()->desabilitados;
        $diasDesabilitados = array();
        foreach ($desabilitados as $desabilitado) {
            array_push($diasDesabilitados, $desabilitado->dia);
        }

        return redirect()->away('https://voucherfacil.com.br');

        // if($lead->data_voucher <= $diasMais && $lead->data_voucher <= $promo["dataFim"] && !in_array($lead->data_voucher, $diasDesabilitados) && count($promo->leads->where('unidade_id', $lead->unidade_id)->where('data_voucher', $lead->data_voucher)) < $promo->limite) {
        //     //pega o ip do lead
        //     $lead->ip = $_SERVER['REMOTE_ADDR'];
        //     $lead->hash = sha1($promocao . $lead->email . date("Y-m-d H:i:s"));
        //     $existe = Lead::where(["promocao_id" => $lead->promocao_id, "unidade_id" => $lead->unidade_id, "data_voucher" => $lead->data_voucher, "email" => $lead->email])->first();
        //     if (!$existe) {
        //         //salva o lead no banco
        //         if (!$lead->save()) {
        //             //log de erro
        //             Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
        //         }
        //         $lead->voucher = $promo->codigo . $lead->id;

        //         if (!$lead->save()) {
        //             Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
        //         }

        //         $date = date('d/m/Y', strtotime($lead->data_voucher));
        //         $lead->dia = $date;

        //         $unidade = $lead->unidade;
        //         $per = $lead->periodo;

        //         //envia email
        //         if(config('app.env') === "production" || config('app.env') === "homolog") {
        //             try {
        //                 $lead->notify(new \App\Notifications\Lead($lead));
        //             } catch(Exception $e) {
        //                 Log::error("Erro ao enviar notificação para slack", ["nome" => $lead->nome, "email" => $lead->email]);
        //             }
        //             $this->sendMailLeadAgendamento($lead, $promo, $unidade, $date, $per->nome);
        //             $this->sendMailVoucher($lead, $promo, $unidade, $date, $per->nome);
        //         }

        //         $agent = new Agent();
        //         $device = ($agent->isMobile() ? ($agent->isTablet() ? 'tablet' : 'mobile') : 'desktop');
        //         $isMobile = $agent->isMobile();

        //         $cores = array(
        //             "bgcolor" => (isset($cli) ? $cli->bgcolor : '#89202b'),
        //             "bgform" => (isset($cli) ? $cli->bgform : '#3d71bc'),
        //             "corfonte" => (isset($cli) ? $cli->corfonte : '#FFFFFF')
        //         );

        //         return view('voucher.content', ['cliente' => $cli, 'promocao' => $promo, 'data' => $date, 'lead' => $lead, 'unidade' => $unidade, 'isMobile' => $isMobile, "cores" => $cores]);
        //     } else {
        //         return redirect($cliente . "/" . $promocao)->withErrors(["nome" => "Agendamento já realizado para esta data."]);
        //     }
        // } else {
        //     return redirect($cliente . "/" . $promocao)->withErrors(["nome" => "Data indisponível para agendamento."]);
        // }
    }

    public function agendamento($cliente, $promocao, $hash) {
        $lead = Lead::where('hash', $hash)->first();
        if (empty($lead->voucher)) {
            $cli = Cliente::where('path', $cliente)->firstOrFail();
            $promo = Promocao::where('path', $promocao)->where("cliente_id", $cli->id)->firstOrFail();
            $diasDesabilitados = DB::select("SELECT DISTINCT(data_voucher) AS dv, (SELECT COUNT(*) FROM leads l WHERE l.unidade_id = $lead->unidade_id AND l.promocao_id = $lead->promocao_id AND l.data_voucher = dv) AS count FROM leads WHERE unidade_id = $lead->unidade_id AND promocao_id = $lead->promocao_id");

            return view('agendamento.content', ['lead' => $lead, 'nome' => $lead->nome, 'cliente' => $cli, 'promocao' => $promo, 'diasDesabilitados' => $diasDesabilitados]);
        } else {
            return redirect($cliente . "/" . $promocao)->withErrors(["nome" => "Agendamento já realizado."]);
        }
    }

    public function reagendamento($cliente, $promocao, $hash) {
        $lead = Lead::where('hash', $hash)->first();
        if (empty($lead->voucher)) {
            $cli = Cliente::where('path', $cliente)->firstOrFail();
            $promo = Promocao::where('path', $promocao)->where("cliente_id", $cli->id)->firstOrFail();
            $diasDesabilitados = DB::select("SELECT DISTINCT(data_voucher) AS dv, (SELECT COUNT(*) FROM leads l WHERE l.unidade_id = $lead->unidade_id AND l.promocao_id = $lead->promocao_id AND l.data_voucher = dv) AS count FROM leads WHERE unidade_id = $lead->unidade_id AND promocao_id = $lead->promocao_id");

            return view('agendamento.reagendamento', ['lead' => $lead, 'nome' => $lead->nome, 'cliente' => $cli, 'promocao' => $promo, 'diasDesabilitados' => $diasDesabilitados]);
        } else {
            return redirect($cliente . "/" . $promocao)->withErrors(["nome" => "Agendamento já realizado."]);
        }
    }

    public function calendario($cliente, $promocao, $idlead) {
        header("Content-Type: text/calendar; charset=utf-8");
        header("Content-Disposition: attachment; filename=calendario.ics");
        $lead = Lead::find($idlead);
        $cli = Cliente::where('path', $cliente)->firstOrFail();
        $promo = Promocao::where('path', $promocao)->where("cliente_id", $cli->id)->firstOrFail();
        $periodo = str_replace(":", "", $lead->periodo->nome);

        $name = "Promoção " . $promo->titulo;
        $data = str_replace("-", "", $lead->data_voucher);
        $location = $lead->unidade->endereco . ", " . $lead->unidade->numero . ", " . $lead->unidade->bairro . (!empty($lead->unidade->complemento) ? ", " . $lead->unidade->complemento : "") . ", " . $lead->unidade->cidade->nome . "-" . $lead->unidade->estado->uf;
        $start = $data . "T{$periodo}00Z";
        $end = $data . "T{$periodo}00Z";
        $description = "descrição";
        $slug = strtolower(str_replace(array(' ', "'", '.'), array('_', '', ''), $name));
        $texto = "";
        echo "BEGIN:VCALENDAR\n";
        echo "VERSION:2.0\n";
        echo "PRODID:-//VoucherFacil.com.br//NONSGML " . "//EN\n";
        echo "METHOD:REQUEST\n";
        echo "BEGIN:VEVENT\n";
        echo "UID:" . $data . "T{$periodo}00-" . rand() . "-voucherfacil.com.br\n"; //Required by Outlook
        echo "DTSTAMP:" . $data . "T{$periodo}00\n";
        echo "DTSTART;TZID=America/Sao_Paulo:" . $start . "\n";
        echo "DTEND;TZID=America/Sao_Paulo:" . $end . "\n";
        echo "LOCATION:" . $location . "\n";
        echo "SUMMARY:" . $name . "\n";
        echo "DESCRIPTION:" . $description . "\n";
        echo "END:VEVENT\n";
        echo "END:VCALENDAR";
        return;
    }

    public function pdf($cliente, $promocao, $voucher) {
        $lead = Lead::where('voucher', $voucher)->first();
        if ($lead) {
            $data = date("d/m/Y", strtotime($lead->data_voucher));

            return \PDF::loadView('voucher.voucher', ['lead' => $lead, 'cliente' => $lead->promocao->cliente, 'promocao' => $lead->promocao, 'data' => $data, 'unidade' => $lead->unidade])->download('pdfvoucher.pdf');
        } else {
            return redirect(url());
        }
    }

    public function sendMailLead($lead, $promocao) {
        //Verifica se sera necessario preencher origem
        if (empty($lead->origem)) {
            $lead->origem = "P9/Nao Identificado";
        }

        //disparar email para o franqueado/franqueadora
        if (config('app.env') === "production") {
            Mail::to(['notificacoesleads@publi9.com.br'])
                ->queue(new \App\Mail\Lead($lead, $promocao));
        } else {
            Mail::to(['heitor.hatakeyama@publi9.com.br'])
                ->queue(new \App\Mail\Lead($lead, $promocao));
        }
    }

    public function sendMailLeadAgendamento($lead, $promocao, $unidade, $dia, $periodo) {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $horaCron = date("Y-m-d 09:00:00");
        $dataHoje = date("Y-m-d");
        $dataVoucher = $lead->data_voucher;

        //Verifica se sera necessario preencher origem
        if (empty($lead->origem)) {
            $lead->origem = "P9/Nao Identificado";
        }

        //disparar email para o franqueado/franqueadora
        /*if(config('app.env') === "production") {
            Mail::to(['notificacoesleads@publi9.com.br'])
                ->queue(new \App\Mail\Agendamento($lead, $promocao, $unidade, $dia, $periodo));
        } else {
            Mail::to(['heitor.hatakeyama@publi9.com.br'])
                ->queue(new \App\Mail\Agendamento($lead, $promocao, $unidade, $dia, $periodo));
        }

        //dispara sms para o usuario
        //\App\Jobs\Sms::dispatch($lead);
        if($horaCron < $hoje && $dataHoje == $dataVoucher) {
            \App\Jobs\SmsAviso::dispatch($lead, $promocao)->delay(now()->addMinutes(10));
        }*/
    }

    public function sendMailVoucher($lead, $promocao, $unidade, $dia, $periodo) {
        //disparar email para o franqueado/franqueadora
        Mail::to([$lead->email])
            ->queue(new \App\Mail\Voucher($lead, $promocao, $unidade, $dia, $periodo));
    }
}
