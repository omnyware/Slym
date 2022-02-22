@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			
			<br>
			<h4>Lista de Mesas</h4>
			<label>Numero de registros: {{count($mesas)}}</label><br>	

			<div class="row">
				@foreach($mesas as $m)

				<div class="col-sm-4 col-lg-4 col-md-6">

					<div class="card card-custom gutter-b">
						<div class="card-header">
							<h3 class="card-title">
								{{$m->nome}}
							</h3>
						</div>	
						<div class="card-body">
							<img style="height: 320px; width: 100%;" src="/mesas/issue/{{$m->id}}">
						</div>	
						<div class="card-footer">
							<a style="width: 100%;" target="_blank" href="/mesas/imprimirQrCode/{{$m->id}}" class="btn btn-light-info">
								<i class="fa fa-print"></i>
								Imprimir
							</a>
						</div>
					</div>
				</div>
				@endforeach				

			</div>
		</div>
	</div>
</div>
@endsection	