
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


<section class="section section-md section-first bg-default text-md-left">
  <div class="container">
    <div class="row row-50 justify-content-center">
      <div class="col-md-10 col-lg-5 col-xl-6">
        @if(sizeof($produto->galeria) > 0)
        <img loading="lazy" src="/imagens_produtos/{{$produto->galeria[0]->path}}" style="width: 519px; height: 420px"/>
        @else
        <img src="/imgs/no_image.png" style="width: 519px; height: 420px"/>
        @endif
      </div>
      <div class="col-md-10 col-lg-7 col-xl-6">
        <h2>{{$produto->produto->nome}}</h2>
        <!-- Bootstrap tabs-->
        <div class="tabs-custom tabs-horizontal tabs-line" id="tabs-4">
          <!-- Nav tabs-->

          <!-- Tab panes-->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tabs-4-1">
              <p>{{$produto->descricao}}</p>
              <p>{{$produto->ingredientes}}</p>
              <div class="text-center text-sm-left offset-top-30">

              </div>
              <div class="group-md group-middle">
                <a class="button button-width-xl-230 button-{{getenv('COLOR_BUTTON')}} button-pipaluk" href="/deliveryProduto/addProduto/{{$produto->id}}">Adicionar ao Carrinho</a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Improve your interior with deco-->

@endsection 