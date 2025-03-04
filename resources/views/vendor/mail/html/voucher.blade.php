<div class="voucher">
  <div class="voucher-header">
    {!!$promocao->resumo!!}
  </div>
  <div class="voucher-wrapper">
    <span class="texto">Voucher:</span>
    <span class="texto-voucher">{{$voucher->voucher}}</span>
  </div>
  <div style="text-align:center;"><img src="https://app.voucherfacil.com.br/storage/{{$voucher->voucher}}.png" /></div>
  <br />
  <p>Apresente o número do voucher ou mostre essa tela no celular</p>
  <div class="valores">
    <div class="data-agendamento">
      <h2>{{$promocao->cliente->razaoSocial . " - " . $promocao->titulo}}</h2>
      <p><span>Agendamento:</span> {{$dia . " - " . ($promocao->id == 5 && in_array($unidade->id, [2, 12]) ? "Atendimento por ordem de chegada" : $periodo)}}</p>
    </div>
    <div class="valor">
      @if(!empty($promocao->valor))
      <p>R$ {{str_replace(".", ",", $promocao->valor)}}</p>
      @endif
    </div>
  </div>
  <div class="informacoes">
    <div class="regras">
      <h3>Regras da oferta</h3>
      <ul>
        <li>{{$promocao->pessoas}}</li>
        <li>*{{$promocao->periodo}}</li>
        <li>**{{$promocao->agendamento}}</li>
      </ul>{!!$promocao->observacoes!!}
      <br />
      {!!$promocao->regras!!}
    </div>
    <div class="localizacao">
      <h3>Onde?</h3>
      <p>{{$unidade->endereco . ", " . $unidade->numero}}</p>
      <p>{{$unidade->bairro}}</p>
      <p>{{$unidade->complemento}}</p>
      <p>{{$unidade->cidade->nome . "/" . $unidade->estado->uf}}</p><br />
      <h3>Contato</h3>
      <p>{{$unidade->telefone}}</p>
    </div>
  </div>
  <div class="compartilhamento">
    <span>Compartilhe com seus amigos</span>
    <div>
      <a id="shareBtn" title="Facebook" href="https://www.facebook.com/sharer/sharer.php?u={{env('SITE_URL') . '/oferta' . '/'. $promocao->cliente->path . '/' . $promocao->path}}" target="_blank"><img src="{{url('imgs/main/icone-facebook.jpg')}}" alt="Facebook" /></a>
      <!-- <a class="twitter-share-button" href="https://twitter.com/share" data-url="{{url($promocao->cliente->path . '/' . $promocao->path)}}" target="_blank"><img src="{{url('imgs/main/icone-twitter.jpg')}}" alt="Twitter" /></a> -->
      <a title="Whatsapp" href="https://api.whatsapp.com/send?text={{env('SITE_URL') . '/oferta' . '/'. $promocao->cliente->path . '/' . $promocao->path}}" target="_blank"><img src="{{url('imgs/main/icone-whatsapp.jpg')}}" alt="Whatsapp" /></a>
    </div>
  </div>
</div>