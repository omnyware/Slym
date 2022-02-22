@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="row">
			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<path d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a href="/clientes" target="_blank" class="text-primary font-weight-bold font-size-h6 mt-2">Clientes: {{$totalDeClientes}}</a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-secondary px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-secondary d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<path d="M5.94290508,4 L18.0570949,4 C18.5865712,4 19.0242774,4.41271535 19.0553693,4.94127798 L19.8754445,18.882556 C19.940307,19.9852194 19.0990032,20.9316862 17.9963398,20.9965487 C17.957234,20.9988491 17.9180691,21 17.8788957,21 L6.12110428,21 C5.01653478,21 4.12110428,20.1045695 4.12110428,19 C4.12110428,18.9608266 4.12225519,18.9216617 4.12455553,18.882556 L4.94463071,4.94127798 C4.97572263,4.41271535 5.41342877,4 5.94290508,4 Z" fill="#000000" opacity="0.3"/>
								<path d="M7,7 L9,7 C9,8.65685425 10.3431458,10 12,10 C13.6568542,10 15,8.65685425 15,7 L17,7 C17,9.76142375 14.7614237,12 12,12 C9.23857625,12 7,9.76142375 7,7 Z" fill="#000000"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a href="/produtos" target="_blank" class="text-secondary font-weight-bold font-size-h6 mt-2">Produtos: {{$totalDeProdutos}}</a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-success px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24"/>
								<path d="M3.52270623,14.028695 C2.82576459,13.3275941 2.82576459,12.19529 3.52270623,11.4941891 L11.6127629,3.54050571 C11.9489429,3.20999263 12.401513,3.0247814 12.8729533,3.0247814 L19.3274172,3.0247814 C20.3201611,3.0247814 21.124939,3.82955935 21.124939,4.82230326 L21.124939,11.2583059 C21.124939,11.7406659 20.9310733,12.2027862 20.5869271,12.5407722 L12.5103155,20.4728108 C12.1731575,20.8103442 11.7156477,21 11.2385688,21 C10.7614899,21 10.3039801,20.8103442 9.9668221,20.4728108 L3.52270623,14.028695 Z M16.9307214,9.01652093 C17.9234653,9.01652093 18.7282432,8.21174298 18.7282432,7.21899907 C18.7282432,6.22625516 17.9234653,5.42147721 16.9307214,5.42147721 C15.9379775,5.42147721 15.1331995,6.22625516 15.1331995,7.21899907 C15.1331995,8.21174298 15.9379775,9.01652093 16.9307214,9.01652093 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a  target="_blank" class="text-success font-weight-bold font-size-h6 mt-2">Vendas: {{number_format($totalDeVendas, 2, ',', '.')}}</a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-info px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-info d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<path d="M8,4 C8.55228475,4 9,4.44771525 9,5 L9,17 L18,17 C18.5522847,17 19,17.4477153 19,18 C19,18.5522847 18.5522847,19 18,19 L9,19 C8.44771525,19 8,18.5522847 8,18 C7.44771525,18 7,17.5522847 7,17 L7,6 L5,6 C4.44771525,6 4,5.55228475 4,5 C4,4.44771525 4.44771525,4 5,4 L8,4 Z" fill="#000000" opacity="0.3"/>
								<rect fill="#000000" opacity="0.3" x="11" y="7" width="8" height="8" rx="4"/>
								<circle fill="#000000" cx="8" cy="18" r="3"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a href="/pedidosDelivery" target="_blank" class="text-info font-weight-bold font-size-h6 mt-2">Pedidos: {{$totalDePedidos}}</a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-success px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
								<rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
								<path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a href="/contasReceber" class="text-success font-weight-bold font-size-h6 mt-2"><span style="font-size: 11px;">Contas a receber: {{number_format($totalDeContaReceber, 2)}}</span></a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4 col-md-4 col-xl-2">

				<div class="col bg-light-danger px-6 py-8 rounded-xl mb-7">
					<span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Add-user.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
								<rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
								<path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000"/>
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<a href="/contasPagar" class="text-danger font-weight-bold font-size-h6 mt-2"><span style="font-size: 11px;">Contas a pagar: {{number_format($totalDeContaPagar, 2)}}</span></a>
				</div>
			</div>

		</div>

		<div class="row">


			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="card card-custom gutter-b example example-compact">
					<div class="card-header">
						<h3 class="card-title">Faturamento</h3>

					</div>
					<div class="card-body">
						<div class="row align-items-center">
							<div class="form-group col-lg-3 col-md-4 col-sm-6">

								<div class="radio-inline" style="margin-top: 30px;">
									<label class="radio radio-outline radio-success">
										<input type="radio" id="test1" name="group1" onchange="alteraModeloGrafico('line')" checked>
										<span></span>Linha
									</label>

									<label class="radio radio-outline radio-success">
										<input type="radio" id="test2" name="group1" onchange="alteraModeloGrafico('pie')" >
										<span></span>Pizza
									</label>

									<label class="radio radio-outline radio-success">
										<input type="radio" id="test3" name="group1" onchange="alteraModeloGrafico('bar')" >
										<span></span>Barra
									</label>


								</div>
							</div>

							<div class="form-group col-lg-3 col-md-4 col-sm-6">
								<label class="col-form-label">Data Inicial</label>
								<div class="">
									<div class="input-group date">
										<input type="text" name="data_inicial" class="form-control date-input" value="{{$dataInicial}}" id="data_inicial" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar"></i>
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group col-lg-3 col-md-4 col-sm-6">
								<label class="col-form-label">Data Final</label>
								<div class="">
									<div class="input-group date">
										<input type="text" name="data_final" class="form-control date-input" value="{{$dataFinal}}" id="data_final" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
								<button onclick="filtrar()" style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Filtrar</button>
							</div>
						</div>


						<div class="row" id="novo-faturamento">
							<canvas id="grafico-faturamento" ></canvas>

						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection	