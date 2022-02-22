<!DOCTYPE html>
<html>
<head>
    <title>Slym</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style type="text/css">
        .phone-data{
            background-image: url();
        }
        h1 {
            font-size: 34px;
        }
    </style>
</head>
<body>

    <nav class="grey darken-3">
        
    </nav>
    

    <div class="row">
        <form class="container" method="post">
            <h5 class="center-align">Informe os dados abaixo para nos ajudar no seu atendimento :)</h5>
            @csrf
            <div class="row">
                <div class="input-field col s12 m6">
                    <input value="{{ old('name') }}" id="name" name="name" type="text" class="validate">
                    <label for="name">Nome</label>
                          
                    @if($errors->has('name'))
                    <div class="center-align">
                        <span class="red-text">{{ $errors->first('name') }}</span>
                    </div>
                    @endif
                </div>
                <div class="input-field col s12 m6">
                    <input value="{{ old('phone') }}" id="phone" name="phone" type="text" class="validate">
                    <label for="phone">Telefone</label>
                          
                    @if($errors->has('phone'))
                    <div class="center-align">
                        <span class="red-text">{{ $errors->first('phone') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <input value="{{ old('brand') }}" id="brand" name="brand" type="text" class="validate">
                    <label for="brand">Marca</label>
                          
                    @if($errors->has('brand'))
                    <div class="center-align">
                        <span class="red-text">{{ $errors->first('brand') }}</span>
                    </div>
                    @endif
                </div>
                <div class="input-field col s12 m6">
                    <input value="{{ old('model') }}" id="model" name="model" type="text" class="validate">
                    <label for="model">Modelo</label>
                          
                    @if($errors->has('model'))
                    <div class="center-align">
                        <span class="red-text">{{ $errors->first('model') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4 offset-m4">
                    <button style="width: 100%" type="submit" class="btn-large">Salvar</button>
                </div>
            </div>

            @if(session()->has('message'))
            <div style="border-radius: 10px;" class="col s12">
                <h5 class="center-align {{ session('color') }}-text">{{ session()->get('message') }}</h5>
                
            </div>
            @endif

        </form>
    </div>
    

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/init.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" src="/js/mascaras.js"></script>
    
</body>
</html>