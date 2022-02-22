
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

<section class="section section-md section-last bg-default text-md-left">
  <div class="container">
    <div class="row row-50">

      <div class="col-lg-12">
        <h5 style="color: #999;">Olá nosso cliente, faça seu cadastro conosco ou efetue o login, para comprar nossos produtos :)</h5>
        <br>
        <h4 class="text-spacing-50">Login</h4><br>
        <form data-form-output="form-output-global" data-form-type="contact" method="post" action="/delivery/login">
          <div class="row row-14 gutters-14">
            @csrf
            <div class="col-12">
              <div class="form-wrap">
                <input class="form-input" id="mail_phone" type="text" name="mail_phone">
                <label class="form-label" for="mail_phone">E-mail ou Telefone</label>
              </div>
            </div>

            <div class="col-12">
              <div class="form-wrap">
                <input class="form-input" id="senha" type="password" name="senha">
                <label class="form-label" for="senha">Senha</label>
              </div>
            </div>
            
          </div>
          <button class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk" type="submit">Login</button>
          

        </form>
        <a class="button button-secondary button-pipaluk" href="/delivery/cadastrar">Quero me cadastrar</a> 
      </div>
    </div>
  </div>
</section>

@endsection 