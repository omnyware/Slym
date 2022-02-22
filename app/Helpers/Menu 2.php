<?php

namespace App\Helpers;


class Menu {

	protected $menu;
	public function __construct(){
		$this->menu = [
			[
				'titulo' => 'Cadastros',
				'icone' => $this->getIcone('Cadastros'),
				'subs' => [
					[
						'nome' => 'Categorias',
						'rota' => '/categorias'
					],
					[
						'nome' => 'Produtos',
						'rota' => '/produtos'
					],
					[
						'nome' => 'Clientes',
						'rota' => '/clientes'
					],
					[
						'nome' => 'Fornecedores',
						'rota' => '/fornecedores'
					],
					[
						'nome' => 'Transportadoras',
						'rota' => '/transportadoras'
					],
					[
						'nome' => 'Funcionarios',
						'rota' => '/funcionarios'
					],
					[
						'nome' => 'Categorias de Serviços',
						'rota' => '/categoriasServico'
					],
					[
						'nome' => 'Serviços',
						'rota' => '/servicos'
					],
					[
						'nome' => 'Lista de Preços',
						'rota' => '/listaDePrecos'
					],
					[
						'nome' => 'Categorias de Contas',
						'rota' => '/categoriasConta'
					],
					[
						'nome' => 'Veiculos',
						'rota' => '/veiculos'
					],
					[
						'nome' => 'Usuários',
						'rota' => '/usuarios'
					],
				]
			],
			[
				'titulo' => 'Entradas',
				'icone' => $this->getIcone('Entradas'),
				'subs' => [
					[
						'nome' => 'Compra Fiscal',
						'rota' => '/compraFiscal'
					],
					[
						'nome' => 'Compra Manual',
						'rota' => '/compraManual'
					],
					[
						'nome' => 'Compras',
						'rota' => '/compras'
					],
					[
						'nome' => 'Cotação',
						'rota' => '/cotacao'
					]
				]
			],
			[
				'titulo' => 'Estoque',
				'icone' => $this->getIcone('Estoque'),
				'subs' => [
					[
						'nome' => 'Ajuste de Estoque',
						'rota' => '/estoque'
					],
					[
						'nome' => 'Apontameto de Produçao',
						'rota' => '/estoque/apontamentoProducao'
					]
				]
			],
			[
				'titulo' => 'Financeiro',
				'icone' => $this->getIcone('Financeiro'),
				'subs' => [
					[
						'nome' => 'Contas a Pagar',
						'rota' => '/contasPagar'
					],
					[
						'nome' => 'Contas a Receber',
						'rota' => '/contasReceber'
					],
					[
						'nome' => 'Fluxo de Caixa',
						'rota' => '/fluxoCaixa'
					],
					[
						'nome' => 'Gráficos',
						'rota' => '/graficos'
					],
					[
						'nome' => 'Relatórios',
						'rota' => '/relatorios'
					]
				]
			],
			[
				'titulo' => 'Configurações',
				'icone' => $this->getIcone('Configurações'),
				'subs' => [
					[
						'nome' => 'Configurar Emitente',
						'rota' => '/configNF'
					],
					[
						'nome' => 'Cadastro do Contador',
						'rota' => '/escritorio'
					],
					[
						'nome' => 'Natureza de Operação',
						'rota' => '/naturezaOperacao'
					],
					[
						'nome' => 'Tributação',
						'rota' => '/tributos'
					],
					[
						'nome' => 'Enviar XML',
						'rota' => '/enviarXml'
					],
					[
						'nome' => 'Manifesto',
						'rota' => '/dfe'
					]
				]
			],
			[
				'titulo' => 'Vendas',
				'icone' => $this->getIcone('Vendas'),
				'subs' => [
					[
						'nome' => 'Vendas',
						'rota' => '/vendas'
					],
					[
						'nome' => 'Nova Venda',
						'rota' => '/vendas/nova'
					],
					[
						'nome' => 'Frente de Caixa',
						'rota' => '/frenteCaixa'
					],
					[
						'nome' => 'Orçamentos',
						'rota' => '/orcamentoVenda'
					],
					[
						'nome' => 'Ordem de Serviço',
						'rota' => '/ordemServico'
					],
					[
						'nome' => 'Conta Crédito',
						'rota' => '/vendasEmCredito'
					],
					[
						'nome' => 'Devolução',
						'rota' => '/devolucao'
					],
					[
						'nome' => 'Agendamentos',
						'rota' => '/agendamentos'
					]
				]
			],
			[
				'titulo' => 'CT-e',
				'icone' => $this->getIcone('CT-e'),
				'subs' => [
					[
						'nome' => 'Lista',
						'rota' => '/cte'
					],
					[
						'nome' => 'Nova',
						'rota' => '/cte/nova'
					],
					[
						'nome' => 'Categorias de Despesa',
						'rota' => '/categoriaDespesa'
					]
				]
			],
			[
				'titulo' => 'MDF-e',
				'icone' => $this->getIcone('MDF-e'),
				'subs' => [
					[
						'nome' => 'Lista',
						'rota' => '/mdfe'
					],
					[
						'nome' => 'Nova',
						'rota' => '/mdfe/nova'
					]
				]
			]
		];
	}

	public function getMenu(){
		return $this->menu;
	}

	public function getIcone($titulo){
		if($titulo == 'Cadastros'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24"></rect>
			<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
			<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
			</g>
			</svg>
			</span>';
		}

		if($titulo == 'Entradas'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<rect fill="#000000" opacity="0.3" transform="translate(9.000000, 12.000000) rotate(-270.000000) translate(-9.000000, -12.000000) " x="8" y="6" width="2" height="12" rx="1" />
			<path d="M20,7.00607258 C19.4477153,7.00607258 19,6.55855153 19,6.00650634 C19,5.45446114 19.4477153,5.00694009 20,5.00694009 L21,5.00694009 C23.209139,5.00694009 25,6.7970243 25,9.00520507 L25,15.001735 C25,17.2099158 23.209139,19 21,19 L9,19 C6.790861,19 5,17.2099158 5,15.001735 L5,8.99826498 C5,6.7900842 6.790861,5 9,5 L10.0000048,5 C10.5522896,5 11.0000048,5.44752105 11.0000048,5.99956624 C11.0000048,6.55161144 10.5522896,6.99913249 10.0000048,6.99913249 L9,6.99913249 C7.8954305,6.99913249 7,7.89417459 7,8.99826498 L7,15.001735 C7,16.1058254 7.8954305,17.0008675 9,17.0008675 L21,17.0008675 C22.1045695,17.0008675 23,16.1058254 23,15.001735 L23,9.00520507 C23,7.90111468 22.1045695,7.00607258 21,7.00607258 L20,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.000000, 12.000000) rotate(-90.000000) translate(-15.000000, -12.000000) " />
			<path d="M16.7928932,9.79289322 C17.1834175,9.40236893 17.8165825,9.40236893 18.2071068,9.79289322 C18.5976311,10.1834175 18.5976311,10.8165825 18.2071068,11.2071068 L15.2071068,14.2071068 C14.8165825,14.5976311 14.1834175,14.5976311 13.7928932,14.2071068 L10.7928932,11.2071068 C10.4023689,10.8165825 10.4023689,10.1834175 10.7928932,9.79289322 C11.1834175,9.40236893 11.8165825,9.40236893 12.2071068,9.79289322 L14.5,12.0857864 L16.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.500000, 12.000000) rotate(-90.000000) translate(-14.500000, -12.000000) " />
			</g>
			</svg>
			</span>';
		}
		if($titulo == 'Estoque'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1" />
			<path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000" />
			</g>
			</svg>
			</span>';
		}
		if($titulo == 'Financeiro'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
			<path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.000019, 10.749981) scale(1, -1) translate(-14.000019, -10.749981) " />
			</g>
			</svg>
			</span>';
		}
		if($titulo == 'Configurações'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
			<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
			<rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
			<rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
			</g>
			</svg>
			</span>';
		}

		if($titulo == 'Vendas'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1" />
			<rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1" />
			<path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000" />
			</g>
			</svg>
			</span>';
		}

		if($titulo == 'CT-e'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<path d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z" fill="#000000" opacity="0.3" />
			<path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
			</g>
			</svg>
			</span>';
		}

		if($titulo == 'MDF-e'){
			return '<span class="svg-icon menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<rect x="0" y="0" width="24" height="24" />
			<path d="M16.5428932,17.4571068 L11,11.9142136 L11,4 C11,3.44771525 11.4477153,3 12,3 C12.5522847,3 13,3.44771525 13,4 L13,11.0857864 L17.9571068,16.0428932 L20.1464466,13.8535534 C20.3417088,13.6582912 20.6582912,13.6582912 20.8535534,13.8535534 C20.9473216,13.9473216 21,14.0744985 21,14.2071068 L21,19.5 C21,19.7761424 20.7761424,20 20.5,20 L15.2071068,20 C14.9309644,20 14.7071068,19.7761424 14.7071068,19.5 C14.7071068,19.3673918 14.7597852,19.2402148 14.8535534,19.1464466 L16.5428932,17.4571068 Z" fill="#000000" fill-rule="nonzero" />
			<path d="M7.24478854,17.1447885 L9.2464466,19.1464466 C9.34021479,19.2402148 9.39289321,19.3673918 9.39289321,19.5 C9.39289321,19.7761424 9.16903559,20 8.89289321,20 L3.52893218,20 C3.25278981,20 3.02893218,19.7761424 3.02893218,19.5 L3.02893218,14.136039 C3.02893218,14.0034307 3.0816106,13.8762538 3.17537879,13.7824856 C3.37064094,13.5872234 3.68722343,13.5872234 3.88248557,13.7824856 L5.82567301,15.725673 L8.85405776,13.1631936 L10.1459422,14.6899662 L7.24478854,17.1447885 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
			</g>
			</svg>
			</span>';
		}
	}
}