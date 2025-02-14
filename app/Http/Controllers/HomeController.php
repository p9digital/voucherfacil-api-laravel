<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Encurtado;
use App\Models\Lead;
use App\Models\Promocao;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller {

    public function utmFix($field, $request) {
        if (!$request->has($field)) {
            $field = "utm_" . $field;
        }
        return $request->input($field);
    }

    public function index() {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $promocoes = Promocao::with("fotos", "cliente")->where('dataInicio', '<=', $hoje)->where("dataFim", '>', $hoje)->where("mostrar", "1")->where("status", "1")->orderBy("dataInicio", "desc")->get();
        // return view('home.content', ["promocoes" => $promocoes]);

        if (config('app.env') === "production") {
            return redirect()->away('https://voucherfacil.com.br');
        } else {
            return redirect()->away('http://localhost:3000/admin');
        }
    }

    public function politica() {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $promocoes = Promocao::with("fotos", "cliente")->where('dataInicio', '<=', $hoje)->where("dataFim", '>', $hoje)->where("mostrar", "1")->where("status", "1")->orderBy("dataInicio", "desc")->get();
        // return view('home.politica', ["promocoes" => $promocoes]);

        return redirect()->away('https://voucherfacil.com.br');
    }

    public function promocoes($cliente) {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $cli = Cliente::where("path", $cliente)->first();
        if ($cli) {
            $promocoes = Promocao::with("fotos", "cliente")->where("cliente_id", $cli->id)->where('dataInicio', '<=', $hoje)->where("dataFim", '>', $hoje)->where("mostrar", "1")->where("status", "1")->orderBy("dataInicio", "desc")->get();
            // return view('home.content', ["promocoes" => $promocoes]);

            return redirect()->away('https://voucherfacil.com.br');
        } else {
            // return redirect("/");
            return redirect()->away('https://voucherfacil.com.br');
        }
    }

    public function promocao(Request $request, $cliente, $promocao, $unidade = null) {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $cli = Cliente::where('path', $cliente)->firstOrFail();
        $promo = Promocao::with("promocaounidades.unidade", "fotos")->where(['path' => $promocao, "cliente_id" => $cli->id, "status" => "1"])->first();
        if ($promo && $promo["dataInicio"] <= $hoje && $promo["dataFim"] > $hoje) {
            //colecao com as informacao de campanha, dispositivo e url de acesso
            //para testes: ?utm_source=teste&utm_medium=teste&utm_term=teste&utm_content=teste&utm_campaign=teste&gclid=teste&origem=teste
            //?source=teste&medium=teste&term=teste&content=teste&campaign=teste&gclid=teste&origem=teste
            $hiddenInputs = collect([
                'urlorigem' => $request->server('HTTP_REFERER'),
                'origem' => $request->input('origem'),
                'gclid' => $request->input('gclid'),
                'utm_source' => $this->utmFix('source', $request),
                'utm_term' => $this->utmFix('term', $request),
                'utm_medium' => $this->utmFix('medium', $request),
                'utm_content' => $this->utmFix('content', $request),
                'utm_campaign' => $this->utmFix('campaign', $request),
                'landing' => $request->fullUrl(),
            ]);
            /*dias que passaram do limite de agendamento por unidade*/
            $promocaounidadeids = $promo->promocaounidades->pluck("unidade_id")->toArray();

            $leads = Lead::selectRaw("unidade_id, data_voucher, COUNT(data_voucher) AS count")->whereIn("unidade_id", $promocaounidadeids)->where("promocao_id", $promo->id)->whereNotNull("data_voucher")->groupBy("unidade_id", "data_voucher")->get();
            if ($promo->promocaounidades) {
                foreach ($promo->promocaounidades as &$promocaoUnidade) {
                    $limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("count", ">=", $promo->limite)->pluck("data_voucher")->toArray();
                    $promocaoUnidade["diasDesabilitados"] = $limites;
                }
            }

            $currentUrl = url()->current();
            if (strpos($currentUrl, '/unidade/') !== false) {
                $currentUrl = url($cli->path . "/" . $promo->path);
            }
            $cores = array(
                "bgcolor" => (isset($cli) ? $cli->bgcolor : '#89202b'),
                "bgform" => (isset($cli) ? $cli->bgform : '#3d71bc'),
                "corfonte" => (isset($cli) ? $cli->corfonte : '#FFFFFF')
            );

            // return view('home.promocao', ["cliente" => $cli, "promocao" => $promo, "hiddenInputs" => $hiddenInputs, "isMobile" => $isMobile, "unidade_id" => $unidade, "currentUrl" => $currentUrl, "cores" => $cores]);

            return redirect()->away('https://voucherfacil.com.br');
        } else {
            // return redirect("/");
            return redirect()->away('https://voucherfacil.com.br');
        }
    }

    public function encurtado($codigo)
    {
        $encurtado = Encurtado::where("codigo", $codigo)->first();
        if($encurtado) {
            // return redirect($encurtado->url);
            return redirect()->away('https://voucherfacil.com.br');
        } else {
            // return redirect("/");
            return redirect()->away('https://voucherfacil.com.br');
        }
    }

    public function qrcode($codigo = null)
    {
        $lead = new Lead();
        if (!empty($codigo)) {
            $lead = Lead::where("voucher", $codigo)->first();
        } else {
            $lead = Lead::all()->last();
        }
        return \QrCode::size(200)->generate($lead->voucher);
    }

    public function search($cliente, $promocao, $function, $argument)
    {
        if (isset($function) && isset($argument)) {
            if ($function == "cidades") {
                $mainOptions = "";
                $commonOptions = "";
                $cidades = DB::table('cidades')
                    ->select('cidades.nome', 'cidades.prioridade', 'cidades.codcidade')
                    ->where('cidades.uf', '=', $argument)
                    ->orderBy('cidades.nome', 'asc')
                    ->get();

                if ($cidades->count()) {
                    foreach ($cidades as $cidade) {
                        //$cidade->nome = utf8_decode($cidade->nome);
                        $commonOptions .= "<option value='" . $cidade->codcidade . "'>" . $cidade->nome . "</option>";

                        if ($cidade->prioridade >= 1 && $cidade->prioridade <= 5) {
                            $mainOptions .= "<option value='" . $cidade->codcidade . "'>" . $cidade->nome . "</option>";
                        }
                    }

                    $response = "<option value='' disabled selected>Cidade de interesse</option>" . $mainOptions . "<option value='' disabled>---</option>" . $commonOptions;
                    echo $response;
                }
            }
        }
    }

    public function contato()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $promocoes = Promocao::with("fotos", "cliente")->where('dataInicio', '<=', $hoje)->where("dataFim", '>', $hoje)->where("mostrar", "1")->where("status", "1")->orderBy("dataInicio", "desc")->get();
        // return view('contato.index', ["promocoes" => $promocoes]);

        return redirect()->away('https://voucherfacil.com.br');
    }

    public function manutencao() {
        // return view('home.manutencao');
        return redirect()->away('https://voucherfacil.com.br');
    }

    public function enviar(Request $request) {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date("Y-m-d H:i:s");
        $promocoes = Promocao::with("fotos", "cliente")->where('dataInicio', '<=', $hoje)->where("dataFim", '>', $hoje)->where("mostrar", "1")->where("status", "1")->orderBy("dataInicio", "desc")->get();

        $validar = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|max:15',
            'assunto' => 'required',
            'mensagem' => 'required'
        ], [
            'nome.required' => 'Digite seu nome',
            'nome.max' => 'Máximo 255 caracteres',
            'email.required'  => 'Digite seu e-mail',
            'email.email' => 'E-mail inválido',
            'email.max' => 'Máximo 255 caracteres',
            'telefone.required'  => 'Digite seu telefone',
            'telefone.max' => 'Máximo 15 caracteres',
            'assunto.required' => 'Selecione um assunto',
            'mensagem.required'  => 'Digite uma mensagem',
        ]);
        if ($request->assunto == "Contato Comercial") {
            $validar = $request->validate([
                'empresa' => 'required|max:255'
            ], [
                'empresa.required' => 'Digite sua empresa',
                'empresa.max' => 'Máximo 255 caracteres'
            ]);
        }

        $contato = new Contato($request->all());
        if (!$contato->save()) {
            return redirect()->back()->withErrors(["erro" => "Ocorreu um erro ao salvar os dados. Verifique os campos foram preenchidos corretamente"]);
        }

        $this->sendMail($contato);

        // return redirect('contato')->with("message", "Contato enviado com sucesso");
        return redirect()->away('https://voucherfacil.com.br');
    }

    private function sendMail($contato)
    {
        if (config('app.env') === "production") {
            Mail::to(['comercial@voucherfacil.com.br'])
                ->queue(new \App\Mail\Contato($contato));
        } else {
            Mail::to(['heitor.hatakeyama@publi9.com.br'])
                ->queue(new \App\Mail\Contato($contato));
        }
    }

    public function filaSms() {
        $leads = Lead::where("data_voucher", ">=", date("Y-m-d"))->where("created_at", "<", "2018-07-05 15:00:00")->orderBy("data_voucher", "ASC")->get();
        foreach ($leads as $lead) {
            $promocao = Promocao::find($lead->promocao_id);
            if ($lead->data_voucher == '2018-05-09') {
                //\App\Jobs\SmsAviso::dispatch($lead, $promocao);
            } else {
                //\App\Jobs\SmsAviso::dispatch($lead, $promocao)->delay(Date($lead->data_voucher . " 09:00:00"));
            }
        }
    }

    private function get_next_alphanumeric($path)
    {
        $chars = str_split("123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ");
        $code_array = str_split($path);
        //Inicia uma busca pelo próximo caractere passível de incremento, ou seja, diferente de Z
        //Note que inicia do último caractere para o primeiro
        for ($i = count($code_array) - 1; $i > -1; $i--) {
            if ($code_array[$i] == "Z") {
                if ($i == 0) {
                    //Se for igual a Z e for o primeiro caractere, então aumenta o comprimento e zera
                    $code_array = array_fill(0, count($code_array) + 1, 0);
                    return implode("", $code_array);
                } else {
                    if ($code_array[$i - 1] != 'Z') {
                        //Se o caractere anterior for diferente de Z, incrementa-o e zera o atual e os subsequentes
                        //Se o caractere anterior for o primeiro, também funciona, pois incrementa ele e zera os demais
                        $code_array[$i - 1] = $chars[array_search($code_array[$i - 1], $chars) + 1];
                        for ($j = $i; $j < count($code_array); $j++) {
                            $code_array[$j] = 0;
                        }
                        return implode("", $code_array);
                    }
                }
            } else {
                //calcula o próximo caractere, ou seja, incrementa o atual
                $code_array[$i] = $chars[array_search($code_array[$i], $chars) + 1];
                if ($i == 0) {
                    //Se for o primeiro caractere, significa que os demais são z
                    //Ou seja, zera eles
                    $novo_array = array_fill(0, count($code_array), 0);
                    $novo_array[0] = $code_array[$i];
                    $code_array = $novo_array;
                }
                return implode("", $code_array);
            }
        }
    }
}
