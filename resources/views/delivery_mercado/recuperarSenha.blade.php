
@extends('delivery_mercado.default')
@section('content')


<section class="section section-md section-last bg-default text-md-left">
  <div class="container">
    <div class="row row-50">

      <div class="col-lg-12">
        <h4 class="text-spacing-50">Esqueceu sua Senha</h4><br>
        <form data-form-output="form-output-global" data-form-type="contact" method="post" action="">
          <div class="row row-14 gutters-14">
            @csrf
            <div class="col-12">
              <div class="form-wrap">
                <input class="form-input" id="mail_phone" type="text" name="mail_phone">
                <label class="form-label" for="mail_phone">E-mail ou Telefone</label>
              </div>
            </div>

            @if(session()->has('message_erro_telefone'))
            <div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro_telefone') }}</div>
            @endif

            <button type="submit" class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk">Recuperar</button>
            @if(session()->has('message_sucesso'))
            <div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
            @endif

            @if(session()->has('message_erro'))
            <div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
            @endif
            
          </div>

          

        </form>

      </div>
    </div>
  </div>
</section>

@endsection 