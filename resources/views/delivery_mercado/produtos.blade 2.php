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
.card{
  margin-top: 10px;
}

.loader {
  border: 10px solid #f3f3f3; /* Light grey */
  border-top: 10px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 30px;
  height: 30px;
  animation: spin 0.5s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

<section class="section section-md bg-default">
  <div class="container">
    @if(isset($pesquisa))
    <h5>Produtos da pesquisa: <strong>{{$pesquisa}}</strong></h5>
    @else
    <h5>Produtos da categora: <strong>{{$categoria->nome}}</strong></h5>
    @endif
    <input type="hidden" id="token" value="{{csrf_token()}}" name="">
    <div class="row">

      @foreach($produtos as $p)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card">

          @if(sizeof($p->galeria) > 0)
          <img src="/imagens_produtos/{{$p->galeria[0]->path}}" style="width: 500px; height: 300px"/>
          @else
          <img src="/imgs/no_image.png" style="width: 500px; height: 300px"/>
          @endif
          <div class="card-body">
            <h5 class="card-title"><a href="/delivery/produto/{{$p->id}}" style="font-size: 17px;" title="Ver">{{$p->produto->nome}}</a></h5>
            <p class="btn btn-danger btn-block" style="margin-top: -20px; font-size: 20px;">R$ {{number_format($p->valor, 2)}} {{$p->produto->unidade_venda}}</p>


            <div class="row" style="margin-top: -10px;">
              <div class="col-3">
                <button onclick="downProd({{$p->id}}, '{{$p->produto->unidade_venda}}')" type="button" class="btn btn-circle btn-lg btn-down">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bag-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
                    <path fill-rule="evenodd" d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                  </svg>
                </button>
              </div>

              <div class="input-group input-group-sm col-6">

                <input disabled id="input_prod_{{$p->id}}" value="{{$p->quantidade}}" type="text" class="form-control" style="text-align: center;">
                

              </div>

              <div class="col-3">
                <button onclick="upProd({{$p->id}}, '{{$p->produto->unidade_venda}}')" type="button" class="btn btn-circle btn-lg btn-up">
                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bag-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
                  <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
                  <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                  <path fill-rule="evenodd" d="M7.5 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-2z"/>
                </svg>
              </button>
            </div>

          </div>
          <div style="display: none;" id="loader_{{$p->id}}" class="loader"></div>

        </div>
      </div>
    </div>
    @endforeach

    @if(sizeof($produtos) == 0)
    <h4>Nenhum produto encontrado :(</h4>
    @endif

  </div>
</div>


</section>

@endsection 