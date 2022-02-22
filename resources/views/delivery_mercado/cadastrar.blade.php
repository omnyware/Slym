
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
      <h4 class="text-spacing-50">Faça seu cadastro :)</h4>
      <form class="rd-form rd-mailform" method="post" action="/delivery/salvarRegistro">
        @csrf
        <div class="row row-14 gutters-14">
          <div class="col-sm-6">
            @if($errors->has('nome'))
            <label class="lbl-erro">{{ $errors->first('nome') }}</label>
            @endif
            <div class="form-wrap @if($errors->has('nome')) has-error @endif">
              <input value="{{old('nome')}}" class="form-input" id="contact-first-name" type="text" name="nome" data-constraints="" placeholder="Nome">

            </div>
          </div>
          <div class="col-sm-6">
            @if($errors->has('sobre_nome'))
            <label class="lbl-erro">{{ $errors->first('sobre_nome') }}/label>
            @endif
            <div class="form-wrap @if($errors->has('sobre_nome')) has-error @endif">
              <input value="{{old('sobre_nome')}}" class="form-input" id="contact-last-name" type="text" name="sobre_nome" data-constraints="" placeholder="Sobrenome">

            </div>
          </div>



          <div class="col-sm-6">
            @if($errors->has('email'))
            <label class="lbl-erro">{{ $errors->first('email') }}</label>
            @endif
            <div class="form-wrap @if($errors->has('email')) has-error @endif">
              <input value="{{old('email')}}" class="form-input" id="contact-last-name" type="email" name="email" data-constraints="" placeholder="Email">

            </div>
          </div>
          <div class="col-sm-6">
            @if($errors->has('celular'))
            <label class="lbl-erro">{{ $errors->first('celular') }}</label>
            @endif
            <div class="form-wrap @if($errors->has('celular')) has-error @endif">
              <input value="{{old('celular')}}" class="form-input" id="celular" type="text" name="celular" placeholder="Celular">

            </div>
          </div>

          <div class="col-sm-6">
            @if($errors->has('senha'))
            <label class="lbl-erro">{{ $errors->first('senha') }}</label>
            @endif
            <div class="form-wrap @if($errors->has('senha')) has-error @endif">
              <input value="{{old('senha')}}" placeholder="Senha" class="form-input" id="contact-last-name" type="password" name="senha" data-constraints="">

            </div>
          </div>
          <div class="col-sm-6">
            @if($errors->has('senha_confirma'))
            <label class="lbl-erro">{{ $errors->first('senha_confirma') }}</label>
            @endif
            <div class="form-wrap @if($errors->has('senha_confirma')) has-error @endif">
              <input value="{{old('senha_confirma')}}" class="form-input" id="contact-last-name" type="password" name="senha_confirma" data-constraints="" placeholder="Confirme a senha">

            </div>
            
          </div>

        </div>
        <button class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk" type="submit">Cadastrar</button>

      </form>
    </div>
  </div>
</div>
</section>

@endsection 