
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
      <h2 class="wow slideInUp" data-wow-delay="0s">Categorias</h2>
    </div>
    <div class="row row-30 justify-content-center">

      @foreach($categorias as $key => $c)
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



<!-- Improve your interior with deco-->

@endsection 