
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

<section class="section section-md bg-default">
  <div class="container">
    <div class="oh">
      <h2 class="wow slideInUp" data-wow-delay="0s">Categorias</h2>
    </div>
    <div class="row row-30 justify-content-center">

      @foreach($categorias['bloco1'] as $key => $c)
      <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay=".{{$key}}s">
        <!-- Team Classic-->
        <article class="team-classic">
          <a class="" href="/delivery/produtos/{{$c->id}}">
            <img loading="lazy" class="img-categoria" src="/imagens_categorias/{{$c->path}}" alt="" width="370" height="406"/>
          </a>
          <div class="team-classic-caption">
            <h5 class="team-classic-name"><a href="#">{{$c->nome}}</a></h5>
          </div>
        </article>
      </div>
      @endforeach

    </div>
  </div>
</section>

<!-- Trending products-->
<section class="section section-md bg-default">
  <div class="container">
    <div class="row row-40 justify-content-center">
      @if($BannerMaisVendido != null)
      <div class="col-sm-8 col-md-7 col-lg-6 wow fadeInLeft" data-wow-delay="0s">
        <div class="product-banner">
          <img loading="lazy" src="/banner_mais_vendido/{{$BannerMaisVendido->path}}" alt="" width="570" height="715"/>
          <div class="product-banner-content">
            <div class="product-banner-inner" style="background-image: url(images/bg-brush.png)">
              <h3 class="text-secondary-1">{{$BannerMaisVendido->texto_primario}}</h3>
              <h2 class="text-primary">{{$BannerMaisVendido->texto_secundario}}</h2>
              @if($BannerMaisVendido->produto_delivery_id != null)
              <a class="button button-{{getenv('COLOR_BUTTON')}} button-ujarak" href="/delivery/produto/{{$BannerMaisVendido->produto_delivery_id}}" data-caption-animate="slideInLeft" data-caption-delay="400">Ver Produto</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endif


      <div class="col-md-5 col-lg-6">
        <div class="row row-30 justify-content-center">

          @if(sizeof($itesMaisVendidosDaSemana) > 0)

          @foreach($itesMaisVendidosDaSemana as $i)
          <div class="col-sm-6 col-md-12 col-lg-6">
            <div class="oh-desktop">
              <!-- Product-->
              <article class="product product-2 box-ordered-item wow slideInRight" data-wow-delay="0s">
                <div class="unit flex-row flex-lg-column">
                  <div class="unit-left">
                    <div class="product-figure">
                      @if(sizeof($i->produto->galeria) > 0)
                      <img loading="lazy" src="/imagens_produtos/{{$i->produto->galeria[0]->path}}" alt="" width="270" height="280"/>
                      @else
                      <img src="/imgs/no_image.png" alt="" width="270" height="280"/>
                      @endif
                      <div class="product-button">
                        <a class="button button-md button-white button-ujarak" href="/delivery/produto/{{$i->produto->id}}">ver</a>
                      </div>
                    </div>
                  </div>
                  <div class="unit-body">
                    <h6 class="product-title"><a href="/delivery/produto/{{$i->produto->id}}">{{$i->produto->produto->nome}}</a></h6>
                    <div class="product-price-wrap">
                      <div class="product-price product-price-old">R$ {{$i->produto->valor}}</div>

                      <div class="product-price">R$ {{$i->produto->valor_anterior}}</div>
                    </div><a class="button button-sm button-{{getenv('COLOR_BUTTON')}} button-ujarak" href="/delivery/produto/{{$i->produto->id}}">Ver</a>
                  </div>
                </div>
              </article>
            </div>
          </div>
          @endforeach

          @else

          @foreach($produtoEmDestaque as $p)
          <div class="col-sm-6 col-md-12 col-lg-6">
            <div class="oh-desktop">
              <!-- Product-->
              <article class="product product-2 box-ordered-item wow slideInRight" data-wow-delay="0s">
                <div class="unit flex-row flex-lg-column">
                  <div class="unit-left">
                    <div class="product-figure">
                      @if(sizeof($p->galeria) > 0)
                      <img loading="lazy" src="/imagens_produtos/{{$p->galeria[0]->path}}" alt="" width="270" height="280"/> 
                      @else
                      <img src="/imgs/no_image.png" alt="" width="270" height="280"/>
                      @endif
                      <div class="product-button">
                        <a class="button button-md button-white button-ujarak" href="/delivery/produto/{{$p->id}}">ver</a>
                      </div>
                    </div>
                  </div>
                  <div class="unit-body">
                    <h6 class="product-title"><a href="/delivery/produto/{{$p->id}}">{{$p->produto->nome}}</a></h6>
                    <div class="product-price-wrap">
                      <div class="product-price product-price-old">R$ {{$p->valor_anterior}}</div>

                      <div class="product-price">R$ {{$p->valor}}</div>
                    </div><a class="button button-sm button-{{getenv('COLOR_BUTTON')}} button-ujarak" href="/delivery/produto/{{$p->id}}">Adicionar ao carrinho</a>
                  </div>
                </div>
              </article>
            </div>
          </div>
          @endforeach

          @endif
          
          
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Team of professionals-->
@if(sizeof($categorias['bloco2']) > 0)
<section class="section section-md bg-default">
  <div class="container">
    <div class="oh">
      <h2 class="wow slideInUp" data-wow-delay="0s">Categorias</h2>
    </div>
    <div class="row row-30 justify-content-center">

      @foreach($categorias['bloco2'] as $key => $c)
      <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay=".{{$key}}s">
        <!-- Team Classic-->
        <article class="team-classic">
          <a class="" href="#">
            <img loading="lazy" class="img-categoria" src="/imagens_categorias/{{$c->path}}" alt="" width="370" height="406"/>
          </a>
          <div class="team-classic-caption">
            <h5 class="team-classic-name"><a href="#">{{$c->nome}}</a></h5>
          </div>
        </article>
      </div>
      @endforeach

    </div>
  </div>
</section>
@endif

<!-- About us-->
<section class="section">
  <div class="parallax-container" loading="lazy" data-parallax-img="images/bg-parallax-2.jpg">
    <div class="parallax-content section-xl context-dark bg-overlay-68">
      <div class="container">
        <div class="row row-lg row-50 justify-content-center border-classic border-classic-big">

          <div class="col-sm-6 col-md-5 col-lg-3 wow fadeInLeft" data-wow-delay=".1s">
            <div class="counter-creative">
              <div class="counter-creative-number"><span class="counter">{{$mercadoConfig->total_de_produtos}}</span><span class="symbol">K</span><span class="icon counter-creative-icon fl-bigmug-line-shopping202"></span>
              </div>
              <h6 class="counter-creative-title">Produtos</h6>
            </div>
          </div>
          <div class="col-sm-6 col-md-5 col-lg-3 wow fadeInLeft" data-wow-delay=".2s">
            <div class="counter-creative">
              <div class="counter-creative-number"><span class="counter">{{$mercadoConfig->total_de_clientes}}</span><span class="icon counter-creative-icon fl-bigmug-line-sun81"></span>
              </div>
              <h6 class="counter-creative-title">Clientes Felizes</h6>
            </div>
          </div>
          <div class="col-sm-6 col-md-5 col-lg-3 wow fadeInLeft" data-wow-delay=".3s">
            <div class="counter-creative">
              <div class="counter-creative-number"><span class="counter">{{$mercadoConfig->total_de_funcionarios}}</span><span class="icon counter-creative-icon fl-bigmug-line-user143"></span>
              </div>
              <h6 class="counter-creative-title">Funcionanrios</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- Improve your interior with deco-->
<section class="section section-md bg-default section-top-image">
  <div class="container">
    <div class="oh h2-title">
      <h2 class="wow slideInUp" data-wow-delay="0s"></h2>
    </div>
    <div class="row row-30" data-lightgallery="group">

      @foreach($produtos as $key => $p)
      <div class="col-sm-6 col-lg-4">
        <div class="oh-desktop">
          <!-- Thumbnail Classic-->
          <article class="thumbnail thumbnail-mary thumbnail-sm wow slideInLeft" data-wow-delay=".{{$key}}s">
            <div class="thumbnail-mary-figure">
              @if(sizeof($p->galeria) > 0)
              <img class="img-para-voce" src="/imagens_produtos/{{$p->galeria[0]->path}}" alt=""/>
              @else
              <img class="img-para-voce" src="/imgs/no_image.png" alt=""/>
              @endif
            </div>
            <div class="thumbnail-mary-caption">
              <a class="icon fl-bigmug-line-zoom60" href="/delivery/produto/{{$p->id}}">
                <img src="images/grid-gallery-1-370x303.jpg" alt="" width="370" height="303"/>
              </a>
              <h4 class="thumbnail-mary-title"><a href="/delivery/produto/{{$p->id}}">{{$p->produto->nome}}</a></h4>
            </div>
          </article>
        </div>
      </div>
      @endforeach

      
      
    </div>
  </div>
</section>
@endsection 