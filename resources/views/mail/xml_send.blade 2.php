<h1>Envio de XML da NF {{$nf}}</h1>
<h2>Valor: {{$valor}}</h2>
<h2>Emissão: {{ \Carbon\Carbon::parse($emissao)->format('d/m/Y H:i:s')}}</h2>


<h4>Att, {{$usuario}}</h4>