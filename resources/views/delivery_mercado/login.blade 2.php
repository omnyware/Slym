
@extends('delivery_mercado.default')
@section('content')


<section class="section section-md section-last bg-default text-md-left">
  <div class="container">
    <div class="row row-50">

      <div class="col-lg-12">
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
        <a class="button button-primary button-pipaluk" href="/delivery/cadastrar">Quero me cadastrar</a> 
        <a class="button button-secondary button-pipaluk" href="/delivery/esqueci-senha">Esqueci minha senha</a> <br><br>
        @if($config->politica_privacidade)
        <a data-toggle="modal" data-target="#modal-politica" href="#" style="font-size: 18px; color: red;" class="" >Politica de privacidade</a> 
        @endif
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-politica" tabindex="-1" role="dialog" aria-labelledby="modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4>Politica de privacidade</h4>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">

          {{$config->politica_privacidade}}
        </div>
      </div>
    </div>
  </div>

</section>

@endsection 