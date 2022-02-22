
@extends('delivery_mercado.default')
@section('content')

<style type="text/css">
.img-categoria{
  height: 300px;
  width: 350px;

}
.img-para-voce{
  height: 300px;
  width: 243px;
}
</style>


<!-- Team of professionals-->

<section class="section section-md bg-default">
  <div class="container">

    <div class="row">
      <div class="container">
        <h2 data-wow-delay="0.1s" class="text-success wow slideInLeft">Obrigado <strong>{{$pedido->cliente->nome}}</strong>, seu pedido foi realizado com sucesso! <i style="color: green" class="fa fa-check"></i></h2>
        <h4 data-wow-delay="0.2s" class="text-success wow slideInRight">Horario: <strong>{{ \Carbon\Carbon::parse($pedido->data_registro)->format('d/m/Y H:i')}}</strong></h4>

        @if($pedido->forma_pagamento != 'pagseguro')
        <h4 data-wow-delay="0.3s" class="text-success wow slideInRight">Forma de Pagamento: <strong>{{ strtoupper($pedido->forma_pagamento)}}</strong></h4>
        @else
        <h4 data-wow-delay="0.3s" class="text-success wow slideInRight">Forma de Pagamento: <strong>Compra on-line</strong> {{$pedido->pagseguro->parcelas}}x cartão</h4>
        @endif

        @if($config)
        <h4 data-wow-delay="0.4s" class="text-success wow slideInLeft">Tempo médio de entrega: <strong>{{$config->tempo_medio_entrega}} minutos</strong></h4><br>
        @endif

      </div>
    </div>

    <div class="card-header p-0">
      <div class="container">
        <h4 class="">ITENS DO PEDIDO</h4>
      </div>
    </div>
    <?php $geral = 0; ?>

    <table id="cart" class="table table-hover table-condensed">
      <thead>
        <tr>
          <th style="width:50%">Produto</th>
          <th style="width:10%">Valor</th>
          <th style="width:8%">Quantidade</th>
          <th style="width:22%" class="text-center">Subtotal</th>

        </tr>
      </thead>
      <tbody data-wow-delay="0.3s" class="text-success wow slideInRight">
        @if($pedido)
        @foreach($pedido->itens as $i)

        <tr>
          <td data-th="Product">
            <div class="row">
              <div class="col-sm-3 hidden-xs">
                @if(isset($i->produto->galeria[0]))
                <img src="/imagens_produtos/{{$i->produto->galeria[0]->path}}" alt="..." class="img-responsive mini"/>
                @else
                <img src="/imgs/no_image.png" alt="..." class="img-responsive mini"/>
                @endif

              </div>
              <div class="col-sm-9">
                <h4 class="nomargin">{{$i->produto->produto->nome}}</h4>
                <p>
                  <?php $total = $i->produto->valor * $i->quantidade; ?>


                  <span>Adicionais: 
                    @if(count($i->itensAdicionais)>0)
                    @foreach($i->itensAdicionais as $a)
                    <strong>{{$a->adicional->nome()}}</strong>
                    <?php  $total += $a->quantidade * $a->adicional->valor * $i->quantidade?>
                    @endforeach
                    @else
                    <label>Nenhum adicional</label>
                    @endif
                  </span>

                  @if(count($i->sabores) > 0)
                  <br>
                  <span>Sabores: 
                    @foreach($i->sabores as $key => $s)
                    <strong>{{$s->produto->produto->nome}}</strong>
                    {{($key+1 >= count($i->sabores) ? '' : '|')}}

                    @endforeach
                  </span><br>
                  <span>Total de sabores: <strong>{{count($i->sabores)}}</strong></span>
                  @endif
                  <br>


                </p>
              </div>
            </div>
          </td>
          @if(count($i->sabores) > 0)
          <?php 
          $maiorValor = 0; 
          $somaValores = 0;
          foreach($i->sabores as $it){
            $v = $it->maiorValor($it->produto->id, $i->tamanho_id);
            $somaValores += $v;
            if($v > $maiorValor) $maiorValor = $v;
          }

          if(getenv("DIVISAO_VALOR_PIZZA") == 1){
            $maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
          }

          $total += $maiorValor * $i->quantidade;
          ?>
          <td data-th="Price">R${{$maiorValor}}</td>

          @else
          <td data-th="Price">R${{$i->produto->valor}}</td>
          @endif
          <td data-th="Quantity">
            <input disabled id="qtd_item_{{$i->id}}" type="text" class="qtd form-control text-center" value="{{(int)$i->quantidade}}">
          </td>


          <td data-th="Subtotal" class="text-center">R${{number_format($total, 2, ',', '.')}}</td>

        </tr>
        <?php $geral += $total; ?>
        @endforeach
        @else
        <div class="container">
          <p class="text-center">Nenhum item no seu carrinho
            <a href="/cardapio" class="btn btn-primary">
              <span class="fa fa-bars"></span> Cardápio
            </a></p>
            <br>
          </div>
          @endif
        </tbody>
        <tfoot data-wow-delay="0.3s" class="text-success wow slideInLeft">
          <tr class="visible-xs">
            <td class="text-center">Total do pedido: <strong style="color: red">R$ {{number_format($geral, 2, ',', '.')}}</strong>
            </td>

          </tr>
          <?php $valorDesconto = 0; ?>
          @if($pedido->cupom)

          <?php 
          $valorDesconto = 0;
          if($pedido->cupom->tipo == 'percentual'){
            $valorDesconto = ($geral*$pedido->cupom->valor)/100;
          }else{
            $valorDesconto = $pedido->cupom->valor;
          }
          ?>
          <tr class="visible-xs">
            <td class="text-center">Cupom de desconto: <strong style="color: blue">{{$pedido->cupom->codigo}}</strong> <strong style="color: green">R$ {{number_format($valorDesconto, 2, ',', '.')}}</strong>
            </td>

          </tr>

          <tr class="visible-xs">
            <td class="text-center">Total com desconto: <strong style="color: red">R$ {{number_format($geral-$valorDesconto, 2, ',', '.')}}</strong>
            </td>

          </tr>
          @endif
          <tr class="visible-xs">
            <td class="text-center">Forma de pagamento:<strong style="color: red"> 
              @if($pedido->forma_pagamento == 'credito')
              Cartão de crédito
              @elseif($pedido->forma_pagamento == 'debito')
              Cartão de débito
              @else
              Dinheiro
              @endif

            </strong>
          </td>

        </tr>
        @if($pedido->endereco_id != null)
        <tr class="visible-xs">

          <td class="text-center"><strong>Taxa de entrega = R${{number_format($pedido->valor_total - $geral, 2, ',', '.')}}</strong></td>

        </tr>

        <trclass="visible-xs">
        <td class="text-center">Endereço: <strong>{{$pedido->endereco->rua}}, {{$pedido->endereco->numero}} - {{$pedido->endereco->bairro}}, {{$pedido->endereco->referencia}}</strong></td>
      </tr>

      <tr class="visible-xs">
        <td class="text-center"><strong>Total pedido + Taxa de entrega = <span style="color: red">R$ {{number_format($pedido->valor_total-$valorDesconto, 2, ',', '.')}}</span></strong></td>
      </tr>
      @else
      <tr class="visible-xs">

        <td class="text-center"><strong>Retirar no balcão</strong></td>

      </tr>
      @endif


    </tfoot>
  </table>

</div>
</section>



<!-- Improve your interior with deco-->

@endsection 