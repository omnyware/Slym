@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/ibpt/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Importação
				</a>
			</div>
		</div>
		<br>
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<br>

			<div class="row">

				@foreach($ibtes as $i)


				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title"><strong style="margin-right: 5px;" class="text-info">{{$i->uf}}</strong> {{$i->versao}} - {{ \Carbon\Carbon::parse($i->updated_at)->format('d/m/Y H:i:s')}}
							</h3>
							<div class="card-toolbar">

								<a href="/ibpt/refresh/{{$i->id}}" class="btn btn-icon btn-circle btn-sm btn-light-primary mr-1"><i class="la la-refresh"></i></a>
								<a href="/ibpt/ver/{{$i->id}}" class="btn btn-icon btn-circle btn-sm btn-light-info mr-1"><i class="la la-list"></i></a>
								

							</div>
						</div>

					</div>

				</div>

				@endforeach

			</div>
		</div>
	</div>
</div>

@endsection