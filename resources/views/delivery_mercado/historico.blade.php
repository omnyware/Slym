
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
    <div class="oh">
      <h3 class="wow slideInUp" data-wow-delay="0s">Meus Pedidos</h3>
    </div>
    <div class="row row-30 justify-content-center">

      @foreach($pedidos as $key => $p)
      <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay=".{{$key}}s">
        <!-- Team Classic-->
        <a href="/delivery/detalhePedido/{{$p->id}}">
          <article class="team-classic">

            <h4>Numero do Pedido: <strong>{{$p->id}}</strong></h4>
            <h4>Data: <strong>{{ \Carbon\Carbon::parse($p->data_registro)->format('d/m/Y H:i:s')}}</strong></h4>
            <h4>Valor: <strong>R$ {{number_format($p->valor_total, 2)}}</strong></h4>

          </article>
        </a>
      </div>
      @endforeach

      @if(sizeof($pedidos) == 0)
      <h4>Nenhum pedido encontrado :(</h4>
      @endif

    </div>
  </div>
</section>



<!-- Improve your interior with deco-->

@endsection 