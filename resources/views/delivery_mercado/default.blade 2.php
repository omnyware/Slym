<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
  <title>{{$title}}</title>
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <!-- <link rel="icon" href="/delivery_mercado/images/favicon.ico" type="image/x-icon"> -->
  <!-- Stylesheets-->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500">
  <link rel="stylesheet" href="/delivery_mercado/css/bootstrap.css">
  <link rel="stylesheet" href="/delivery_mercado/css/fonts.css">
  <link rel="stylesheet" href="/delivery_mercado/css/style.css">

  <style type="text/css">
  .img-carrinho{
    width: 108px; height: 100px;
  }

  body{
    font-family: sans-serif;
  }
  @media only screen and (min-width: 200px) and (max-width: 1000px){
    .fab{
      position: fixed;
      bottom:60px;
      right:10px;
    }
  }

  /*@media only screen and (min-width: 1300px){
    .fab{
      position: fixed;
      bottom:90px;
      right:30px;
    }
  }*/


  .fab a{
    cursor: pointer;
    width: 60px;
    height: 60px;
    border-radius: 30px;
    background-color: #6576AD;
    border: none;
    box-shadow: 0 1px 5px rgba(0,0,0,.1);
    font-size: 24px;
    color: white;
  }

  .fab a:focus{
    outline: none;
  }

  .fab a.main{
    position: absolute;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #6576AD;
    right: 0;
    bottom: 0;
    z-index: 20;
  }

</style>

<!-- Colar OneSignal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "<?php echo getenv('ONE_SIGNAL_APP_ID'); ?>",
    });

  });
</script>

<!-- Fim Colar OneSignal -->


<script type="text/javascript">

  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    let path = window.location.protocol + '//' + window.location.host
    let user = $('#user').val() ? $('#user').val() : 0;

    OneSignal.getUserId().then(function(userId) {
      let js = {
        user: user,
        token: userId
      }
      console.log(js)
      console.log("OneSignal User ID:", userId);
      $.get(path + '/autenticar/saveTokenWeb', js)
      .done((res) => {
        console.log(res)
      })  
      .fail((err) => {
        console.log(err)
      })    
    });
  });
</script>


</head>
<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container"><span></span><span></span><span></span><span></span>
      </div>
    </div>
  </div>
  <div class="page">
    <!-- Page Header-->
    <header class="section page-header">
      <!-- RD Navbar-->
      <div class="rd-navbar-wrap rd-navbar-modern-wrap">
        <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="70px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
          <div class="rd-navbar-main-outer">
            <div class="rd-navbar-main">
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <!-- RD Navbar Toggle-->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand" href="/"><img src="/images/logo.png" alt="" width="196" height="47"/>{{$config->nomeExib(0)}} {{$config->nomeExib(1)}}</a></div>
              </div>
              <div class="rd-navbar-main-element">
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Basket-->
                  <!-- Inicio Carrinho-->
                  <div class="rd-navbar-basket-wrap">
                    <button class="rd-navbar-basket fl-bigmug-line-shopping198" data-rd-navbar-toggle=".cart-inline"><span id="qtd_carrinho">0</span></button>

                    <div class="cart-inline">
                      <div class="cart-inline-header">
                        <h5 class="cart-inline-title">Carrinho: <span id="qtd_carrinho_2"> 0</span> Produtos</h5>
                        <h6 class="cart-inline-title">Total: <span id="total_carrinho"> R$ 0,00</span></h6>
                      </div>
                      
                      <div class="cart-inline-body" id="carrinho_html">


                      </div>

                      <div class="cart-inline-footer">
                        <div class="group-sm"><a class="button button-md button-default-outline-2 button-wapasha" href="/delivery/carrinho">Ver Carrinho</a></div>
                      </div>
                    </div>
                  </div>

                  @if(session('cliente_log')['id'])
                  <input type="hidden" value="{{session('cliente_log')['id']}}" id="user">
                  @endif

                  <a class="rd-navbar-basket rd-navbar-basket-mobile fl-bigmug-line-shopping198" href="/delivery/carrinho"><span></span></a>
                  <!-- Fim carrinho -->
                  <!-- RD Navbar Search-->
                  <div class="rd-navbar-search">
                    <button class="rd-navbar-search-toggle" data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
                    <form class="rd-search" action="/delivery/pesquisaProduto">
                      <div class="form-wrap">
                        <label class="form-label" for="rd-navbar-search-form-input">O que deseja comprar?</label>
                        <input class="rd-navbar-search-form-input form-input" id="rd-navbar-search-form-input" type="text" name="search">
                        <button class="rd-search-form-submit fl-bigmug-line-search74" type="submit"></button>
                      </div>
                    </form>
                  </div>
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                    <li class="rd-nav-item @if($rota == 'inicio') active @endif"><a class="rd-nav-link" href="/delivery">Inicio</a>
                    </li>
                    <li class="rd-nav-item @if($rota == 'categorias') active @endif"><a class="rd-nav-link" href="/delivery/categorias">Categorias</a>
                    </li>
                    @if(!session('cliente_log')['id'])
                    <li class="rd-nav-item @if($rota == 'login') active @endif"><a class="rd-nav-link" href="/delivery/login">Login</a>
                    </li>
                    @else
                    <li class="rd-nav-item @if($rota == 'login') active @endif"><a class="rd-nav-link" href="/delivery/logoff">Logoff</a>
                    </li>
                    <li class="rd-nav-item @if($rota == 'meus_pedidos') active @endif"><a class="rd-nav-link" href="/delivery/meusPedidos">Meus Pedidos</a>
                    </li>

                    @endif
                  </ul>

                  <input type="hidden" value="{{{ session('cliente_log')['id'] ? 1 : 0 }}}" id="cliente_logado" name="">
                </div>
                <div class="rd-navbar-project-hamburger" data-multitoggle=".rd-navbar-main" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                  <div class="project-hamburger"><span class="project-hamburger-arrow-top"></span><span class="project-hamburger-arrow-center"></span><span class="project-hamburger-arrow-bottom"></span></div>
                  <div class="project-hamburger-2"><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span>
                  </div>
                  <div class="project-close"><span></span><span></span></div>
                </div>
              </div>


              <div class="rd-navbar-project rd-navbar-modern-project">
                <div class="rd-navbar-project-modern-header">
                  <h4 class="rd-navbar-project-modern-title">Entrar em Contato</h4>
                  <div class="rd-navbar-project-hamburger" data-multitoggle=".rd-navbar-main" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                    <div class="project-close"><span></span><span></span></div>
                  </div>
                </div>
                <div class="rd-navbar-project-content rd-navbar-modern-project-content">
                  <div>
                    <p>Estamos sempre prontos para fornecer os melhores produtos e o melhor atendimento.</p>
                    <div class="heading-6 subtitle">Nossos Contatos</div>
                    <div class="row row-10 gutters-10">

                    </div>
                    <ul class="rd-navbar-modern-contacts">
                      <li>
                        <div class="unit unit-spacing-sm">
                          <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                          <div class="unit-body"><a class="link-phone" href="tel:{{$config->telefone}}">{{$config->telefone}}</a></div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-sm">
                          <div class="unit-left"><span class="icon fa fa-location-arrow"></span></div>
                          <div class="unit-body"><a class="link-location" href="#">{{$config->endereco}}</a></div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-sm">
                          <div class="unit-left"><span class="icon fa fa-envelope"></span></div>
                          <div class="unit-body"><a class="link-email" href="mailto:{{getenv('MAIL_USERNAME')}}">{{getenv('MAIL_USERNAME')}}</a></div>
                        </div>
                      </li>
                    </ul>
                    <ul class="list-inline rd-navbar-modern-list-social">
                      @if($config->link_face)
                      <li><a class="icon fa fa-facebook" href="{{$config->link_face}}"></a></li>
                      @endif

                      @if($config->link_twiteer)
                      <li><a class="icon fa fa-twitter" href="{{$config->link_twiteer}}"></a></li>
                      @endif

                      @if($config->link_google)
                      <li><a class="icon fa fa-google-plus" href="{{$config->link_google}}"></a></li>
                      @endif

                      @if($config->link_instagram)
                      <li><a class="icon fa fa-instagram" href="{{$config->link_instagram}}"></a></li>
                      @endif


                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- Swiper-->
    @if(session()->has('message_sucesso'))
    <div class="alert alert-success" role="alert">{{ session()->get('message_sucesso') }}</div>
    @endif
    @if(session()->has('message_erro'))
    <div class="alert alert-danger" role="alert">{{ session()->get('message_erro') }}</div>
    @endif

    @isset($bannersTopo)
    <section class="section swiper-container swiper-slider swiper-slider-modern" data-loop="true" data-autoplay="5000" data-simulate-touch="true" data-nav="true" data-slide-effect="fade">
      <div class="swiper-wrapper text-left">


        @foreach($bannersTopo as $b)
        <div class="swiper-slide context-dark" data-slide-bg="/banner_topo/{{$b->path}}">
          <div class="swiper-slide-caption">
            <div class="container">
              <div class="row justify-content-center justify-content-xxl-start">
                <div class="col-md-10 col-xxl-6">
                  <div class="slider-modern-box">
                    <h1 class="slider-modern-title"><span data-caption-animate="slideInDown" data-caption-delay="0">
                      {{$b->titulo}}
                    </span></h1>
                    <p data-caption-animate="fadeInRight" data-caption-delay="400">
                      {{$b->descricao}}
                    </p>
                    <div class="oh button-wrap">
                      @if($b->produto_delivery_id != null)
                      <a class="button button-{{getenv('COLOR_BUTTON')}} button-ujarak" href="/delivery/produto/{{$b->produto->id}}" data-caption-animate="slideInLeft" data-caption-delay="400">Ver Produto</a>

                      @elseif($b->pack_id != null)
                      <a class="button button-{{getenv('COLOR_BUTTON')}} button-ujarak" href="/delivery/pack/{{$b->pack->id}}" data-caption-animate="slideInLeft" data-caption-delay="400">Ver Promoção</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach




      </div>
      <!-- Swiper Navigation-->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <!-- Swiper Pagination-->
      <div class="swiper-pagination swiper-pagination-style-2"></div>
    </section>
    @endisset


    <!-- FIM FATIA INICIO -->

    @yield('content')

    <div class="fab">
      <a class="main" href="/delivery/carrinho">
        <span style="color: #fff; font-size: 35px; margin-left: 5px; margin-top: 7px;" class="fa fa-shopping-cart mr-2">
        </span><strong style="margin-left: -7px; font-size: 17px;" id="qtd-itens"></strong>
        </a>
      </div>

      <!-- Page Footer-->
      <footer class="section footer-variant-2 footer-modern context-dark section-top-image section-top-image-dark">
        <div class="footer-variant-2-content">
          <div class="container">
            <div class="row row-40 justify-content-between">
              <div class="col-sm-9 col-lg-9 col-xl-9">
                <div class="oh-desktop">
                  <div class="wow slideInRight" data-wow-delay="0s">
                    <div class="footer-brand"><a href="index.html"></a></div>
                    <p>{{$mercadoConfig->descricao}}.</p>
                    <ul class="footer-contacts d-inline-block d-md-block">
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                          <div class="unit-body"><a class="link-phone" href="tel:#">{{$config->telefone}}</a></div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-clock-o"></span></div>
                          <div class="unit-body">
                            <p>{{$mercadoConfig->funcionamento}}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-location-arrow"></span></div>
                          <div class="unit-body"><a class="link-location" href="#">{{$config->endereco}}</a></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-xl-3">
                <div class="oh-desktop">
                  <div class="inset-top-18 wow slideInLeft" data-wow-delay="0s">
                    <h5></h5>
                    <div class="row row-10 gutters-10" data-lightgallery="group">

                      @foreach($imagens as $i)
                      <div class="col-6 col-sm-3 col-lg-6">
                        <!-- Thumbnail Classic-->
                        <article class="thumbnail thumbnail-mary">
                          <div class="thumbnail-mary-figure">
                            <img style="width: 129px; height: 120px" src="/imagens_categorias/{{$i}}" alt="" width="129" height="120"/>
                          </div>
                          <div class="thumbnail-mary-caption">
                            <a class="icon fl-bigmug-line-zoom60" href="/imagens_categorias/{{$i}}" data-lightgallery="item">
                              <img style="width: 129px; height: 120px" src="/imagens_categorias/{{$i}}" />
                            </a>
                          </div>
                        </article>
                      </div>
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-variant-2-bottom-panel">
          <div class="container">
            <!-- Rights-->
            <div class="group-sm group-sm-justify">
              <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span> <span>Slym</span>.
              </p>
              <p class="rights">Design&nbsp;by&nbsp;<a href="https://www.templatemonster.com/">Slym</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <?php $path = getenv('PATH_URL')."/";?>
    <script type="text/javascript">
      const path = "{{$path}}";
    </script>
    <!-- Javascript-->
    <script src="/delivery_mercado/js/core.min.js"></script>
    <script src="/delivery_mercado/js/script.js"></script>
    <script type="text/javascript" src="/js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/js/mascaras.js"></script>
    <script type="text/javascript" src="/jsd/mercado_produto.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    @isset($cadastro_ative_mercado_js)
    <script type="text/javascript" src="/jsd/cadastro_ative_mercado.js"></script>
    @endisset

    @if(isset($mapaJs))
    <script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
    async defer></script>
    @endif

    @if(isset($forma_pagamento))
    <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

    <script src="/jsd/card.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>

    <script type="text/javascript">

      new Card({
        form: document.querySelector('#form-pag'),
        container: '.card-wrapper',
        width: 300,
        placeholders: {
          number: '•••• •••• •••• ••••',
          name: 'Nome Completo',
          expiry: '••/••••',
          cvc: 'CVC'
        },
        debug: true,
        formSelectors: {
          numberInput: 'input#number', 
          expiryInput: 'input#validade', 
          cvcInput: 'input#cvc', 
          nameInput: 'input#nome' 
        },
      });

    </script>
    @endif
    <!-- coded by Ragnar-->
  </body>
  </html>