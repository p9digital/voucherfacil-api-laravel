<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocoesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('promocoes')->delete();

        DB::table('promocoes')->insert(array(
            0 =>
            array(
                'id' => 1,
                'cliente_id' => 1,
                'titulo' => 'Alphaville',
                'path' => 'alphaville',
                'resumo' => '<p>Almoço ou jantar para duas pessoas - R$145,90</p><p>2 Saladas, 2 entrecôtes, sobremesa e 1 garrafa de vinho ou porção de queijos</p>',
                'descricao' => 'Descrição',
                'regras' => '<p><strong>Almoço ou jantar no L’Entrecôte de Paris Alphaville</strong></p><br /><p>2 Saladas</p><p>2 Entrecôtes</p><p>1 Sobremesa compartilhada (Crème Caramel ou Mousse Chocolat Nuage)</p><p>1 Garrafa de vinho da casa ou prato de queijos sortidos (cliente escolhe no ato da reserva)</p><p>Serviço cobrado à parte</p><p>Necessário fazer reserva</p><br /><p><strong>Importante:</strong></p><p>Sujeito à disponibilidade de data e horário. Preencha o formulário para retirar seu voucher e consultar as datas disponíveis para agendamento.</p><p>Válido para consumo no local.</p><p>Outros itens do cardápio são cobrados à parte</p>',
                'observacoes' => '<p><small><i><strong>*consultar horário de funcionamento da casa</strong></i></small><br /><small><i><strong>**Válido para todos os dias, exceto datas comemorativas</strong></i></small></p>',
                'desconto' => '30%',
                'valor' => '145.90',
                'codigo' => 'LDP',
                'dataInicio' => '2018-03-08 00:00:00',
                'dataFim' => '2018-07-08 11:54:59',
                'dataPublicacao' => '2018-05-09 00:00:00',
                'pessoas' => 'Para duas pessoas',
                'periodo' => 'Almoço ou jantar',
                'agendamento' => 'Necessário Agendamento',
                'limite' => 50,
                'imagem' => 'imagem.jpg',
                'metaDescription' => 'Almoço ou jantar para duas pessoas - R$145,90. 2 Saladas, 2 entrecôtes, sobremesa e 1 garrafa de vinho ou porção de queijos',
                'metaKeywords' => 'voucherfacil,voucher facil,voucher,l\'entrecote de paris,lentrecote de paris,desconto,promocao,comida francesa,alphaville',
                'codigosAcompanhamento' => '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116415121-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag("js", new Date());
gtag("config", "UA-116415121-1");
</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,"script",
"https://connect.facebook.net/en_US/fbevents.js");
fbq("init", "359220561247811");
fbq("track", "PageView");
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=359220561247811&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->',
                'codigosConversao' => '<!-- Google Code for P9 / VF LDP Alphaville / Voucher Recebido Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 811104816;
var google_conversion_label = "OPMjCI3sxH8QsPThggM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/811104816/?label=OPMjCI3sxH8QsPThggM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>',
                'mostrar' => '0',
                'created_at' => '2018-03-08 14:18:45',
                'updated_at' => NULL,
                'status' => '1',
            ),
            1 =>
            array(
                'id' => 2,
                'cliente_id' => 1,
                'titulo' => 'Combo Apaixonante',
                'path' => 'combo-apaixonante',
                'resumo' => '<p>Almoço ou jantar para duas pessoas - R$ 169,00</p><p>1 Petit Fromage, 2 Saladas, 2 Entrecôtes, 2 Sobremesas</p>',
                'descricao' => 'Descrição',
                'regras' => '<p><strong>Almoço ou jantar no L’Entrecôte de Paris</strong></p><br /><p><strong>R$ 169,00 de desconto</strong></p><p>1 Petit Fromage</p><p>2 Saladas</p><p>2 Entrecôtes</p><p>2 Sobremesas (a escolha do cliente)</p><p>Serviço cobrado à parte</p><p>Necessário fazer reserva</p><br /><p><strong>Importante:</strong></p><p>Sujeito à disponibilidade de data e horário. Preencha o formulário para retirar seu voucher e consultar as datas disponíveis para agendamento.</p><p>Válido para consumo no local selecionado.</p><p>Outros itens do cardápio são cobrados à parte.</p>',
                'observacoes' => '<p><small><i><strong>*Consultar horário de funcionamento da unidade escolhida</strong></i></small><br /><small><i><strong>**Válido para todos os dias do mês de Junho</strong></i></small><br /><small><i><strong>***Promoção não cumulativa</strong></i></small></p>',
                'desconto' => NULL,
                'valor' => '169.00',
                'codigo' => 'LDP',
                'dataInicio' => '2018-05-01 00:00:00',
                'dataFim' => '2018-07-01 00:00:00',
                'dataPublicacao' => '2018-06-01 00:00:00',
                'pessoas' => 'Para duas pessoas',
                'periodo' => 'Almoço ou jantar',
                'agendamento' => 'Necessário Agendamento',
                'limite' => 50,
                'imagem' => 'imagem.jpg',
                'metaDescription' => 'Almoço ou jantar para duas pessoas. 1 Petit Fromage, 2 Saladas, 2 Entrecôtes, 2 Sobremesas',
                'metaKeywords' => 'voucherfacil,voucher facil,voucher,l\'entrecote de paris,lentrecote de paris,combo apaixonante,dia dos namorados,desconto,promocao dia dos namorados,restaurante,comida francesa',
                'codigosAcompanhamento' => '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116415121-2"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag("js", new Date());
gtag("config", "UA-116415121-2");
</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,"script",
"https://connect.facebook.net/en_US/fbevents.js");
fbq("init", "1256320421138130");
fbq("track", "PageView");
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1256320421138130&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->',
                'codigosConversao' => '<!-- Google Code for P9 / VF LDP Nacional / Voucher Enviado Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 802507550;
var google_conversion_label = "LvKbCP7aqIMBEJ6W1f4C";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/802507550/?label=LvKbCP7aqIMBEJ6W1f4C&amp;guid=ON&amp;script=0"/>
</div>
</noscript>',
                'mostrar' => '1',
                'created_at' => '2018-05-28 11:41:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            2 =>
            array(
                'id' => 3,
                'cliente_id' => 1,
                'titulo' => 'Alphaville Entrecôte com Vinho',
                'path' => 'alphaville-entrecote-com-vinho',
                'resumo' => '<p>Almoço ou jantar para 2 pessoas + vinho = R$185,00</p><p>2 Saladas, 2 entrecôtes, 2 sobremesas do dia e 1 garrafa de vinho 750 ml</p>',
                'descricao' => 'Descrição',
                'regras' => '<p><strong>Almoço ou jantar no L’Entrecôte de Paris Alphaville</strong></p><br /><p>2 Saladas</p><p>2 Entrecôtes</p><p>2 Sobremesas do dia</p><p>1 Garrafa de vinho da casa</p><p>Serviço cobrado à parte</p><p>Necessário fazer reserva</p><br /><p><strong>Importante:</strong></p><p>Sujeito à disponibilidade de data e horário. Preencha o formulário para retirar seu voucher e consultar as datas disponíveis para agendamento.</p><p>Válido para consumo no local.</p><p>Outros itens do cardápio são cobrados à parte</p>',
                'observacoes' => '<p><small><i><strong>*consultar horário de funcionamento da casa</strong></i></small><br /><small><i><strong>**Válido para todos os dias, exceto datas comemorativas</strong></i></small><br /><small><i><strong>Obrigatório reserva</strong></i></small><br /><small><i><strong>Não cumulativo com outras promoções</strong></i></small></p>',
                'desconto' => NULL,
                'valor' => '185.00',
                'codigo' => 'LDP',
                'dataInicio' => '2018-06-05 00:00:00',
                'dataFim' => '2018-12-25 00:00:00',
                'dataPublicacao' => '2018-06-05 00:00:00',
                'pessoas' => 'Para duas pessoas',
                'periodo' => 'Almoço ou jantar',
                'agendamento' => 'Necessário Agendamento',
                'limite' => 50,
                'imagem' => 'imagem.jpg',
                'metaDescription' => 'Almoço ou jantar para 2 pessoas + vinho = R$185,00. 2 Saladas, 2 entrecôtes, 2 sobremesas do dia e 1 garrafa de vinho 750 ml',
                'metaKeywords' => 'voucherfacil,voucher facil,voucher,l\'entrecote de paris,lentrecote de paris,desconto,promocao,comida francesa,alphaville',
                'codigosAcompanhamento' => NULL,
                'codigosConversao' => NULL,
                'mostrar' => '0',
                'created_at' => '2018-06-05 09:46:03',
                'updated_at' => NULL,
                'status' => '0',
            ),
            3 =>
            array(
                'id' => 4,
                'cliente_id' => 1,
                'titulo' => 'Alphaville Entrecôte executivo',
                'path' => 'alphaville-entrecote-executivo',
                'resumo' => '<p>Almoço executivo para 1 pessoa = R$59,90</p><p>1 salada, 1 entrecôte, 1 sobremesa do dia</p>',
                'descricao' => 'Descrição',
                'regras' => '<p><strong>Almoço no L’Entrecôte de Paris Alphaville</strong></p><br /><p>1 Salada</p><p>1 Entrecôte</p><p>1 Sobremesa do dia</p><p>Serviço cobrado à parte</p><p>Necessário fazer reserva</p><br /><p><strong>Importante:</strong></p><p>Sujeito à disponibilidade de data e horário. Preencha o formulário para retirar seu voucher e consultar as datas disponíveis para agendamento.</p><p>Válido para consumo no local.</p><p>Outros itens do cardápio são cobrados à parte</p>',
                'observacoes' => '<p><small><i><strong>*consultar horário de funcionamento da casa</strong></i></small><br /><small><i><strong>**Válido para almoço executivo das 12:00 às 15:00, de segunda a sexta, exceto feriados.</strong></i></small><br /><small><i><strong>Não necessita reserva</strong></i></small><br /><small><i><strong>Não cumulativo com outras promoções</strong></i></small></p>',
                'desconto' => NULL,
                'valor' => '59.90',
                'codigo' => 'LDP',
                'dataInicio' => '2018-06-05 00:00:00',
                'dataFim' => '2018-12-25 00:00:00',
                'dataPublicacao' => '2018-06-05 00:00:00',
                'pessoas' => 'Para uma pessoa',
                'periodo' => 'Almoço',
                'agendamento' => 'Necessário Agendamento',
                'limite' => 50,
                'imagem' => 'imagem.jpg',
                'metaDescription' => 'Almoço executivo para 1 pessoa = R$59,90. 1 salada, 1 entrecôte, 1 sobremesa do dia',
                'metaKeywords' => 'voucherfacil,voucher facil,voucher,l\'entrecote de paris,lentrecote de paris,desconto,promocao,comida francesa,alphaville',
                'codigosAcompanhamento' => NULL,
                'codigosConversao' => NULL,
                'mostrar' => '0',
                'created_at' => '2018-06-05 09:46:03',
                'updated_at' => NULL,
                'status' => '0',
            ),
        ));
    }
}
