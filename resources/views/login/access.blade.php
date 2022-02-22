
<!DOCTYPE html>
<html lang="en">


<head>
  
  <title>Login Page</title>

  <!-- Favicons-->
  <!-- Favicons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->

  <style type="text/css">
    .container{
      margin-top: 10%;
    }
    img{
      width: 200px;
      height: 120px;
      margin-bottom: 50px;
    }
  </style>
</head>

<body class="">
  
  <div class="container">
    <div class="center-align">
     
      @if(!session()->has('message'))
      <img style="height: 160px;" src="../imgs/slym.png">
      @else
      <img style="height: 220px;" src="https://image.dhgate.com/0x0s/f2-albu-g2-M00-E4-69-rBVaG1oqYk2AVdlNAAEhoQ9wxGI364.jpg/decalque-do-carro-m-scara-an-nima-homem-sexy.jpg">
      <div class="{{ session('color') }} lighten-1">
        <h5 class="center-align white-text">{{ session()->get('message') }}</h5>
      </div>
      @endif

      @if(session()->has('message_logoff'))
      <div class="{{ session('color') }} lighten-1">
        <h5 class="center-align white-text">{{ session()->get('message') }}</h5>
      </div>
      @endif

      
      <form class="form-signin" method="post" action="/login/request">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="input-field col s6 offset-s3">
            <input autofocus="true" class="validate" id="login" autocomplete="off" type="text" name="login" autofocus>
            <label for="login">Login</label>

          </div>
        </div>

        <div class="row">
          <div class="input-field col s6 offset-s3">
            
            <input class="validate" type="password" name="senha">
            <label>Senha</label>

          </div>
        </div>

        <button class="btn btn-large green accent-3" type="submit">Acessar</button>
      </form>
      <br>


    </div>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
  <script type="text/javascript" src="js/init.js"></script>

</body>

</html>