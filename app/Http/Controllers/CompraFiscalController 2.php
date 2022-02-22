<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Categoria;
use App\ItemCompra;
use App\Fornecedor;
use App\Compra;
use App\Helpers\StockMove;
use App\Cidade;
use App\ConfigNota;
use App\ManifestaDfe;
use App\NaturezaOperacao;
use App\Services\DFeService;

class CompraFiscalController extends Controller
{
	protected $empresa_id = null;
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$this->empresa_id = $request->empresa_id;
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	
	public function index(){
		$natureza = Produto::firstNatureza($this->empresa_id);
		if($natureza == null){
			session()->flash('mensagem_erro', 'Cadastre uma natureza de operação!');
			return redirect('/naturezaOperacao');
		}

		$categoria = Categoria::
		where('empresa_id', $this->empresa_id)
		->first();
		if($categoria == null){
			session()->flash('mensagem_erro', 'Cadastre uma categoria de produto!');
			return redirect('/categorias');
		}
		return view('compraFiscal/new')
		->with('title', 'Compra Fiscal');
	}

	private function validaChave($chave){
		$msg = "";
		$chave = substr($chave, 3, 44);

		$cp = Compra::
		where('chave', $chave)
		->where('empresa_id', $this->empresa_id)
		->first();

		$manifesto = ManifestaDfe::
		where('chave', $chave)
		->where('empresa_id', $this->empresa_id)
		->first();

		if($cp != null) $msg = "XML já importado na compra fiscal";
		if($manifesto != null) $msg .= "XML já importado através do manifesto fiscal";
		return $msg;
	}

	public function new(Request $request){
		if ($request->hasFile('file')){
			$arquivo = $request->hasFile('file');
			$xml = simplexml_load_file($request->file);

			$msgImport = $this->validaChave($xml->NFe->infNFe->attributes()->Id);
			if($msgImport == ""){
			//var_dump($xml);

				$cidade = Cidade::getCidadeCod($xml->NFe->infNFe->emit->enderEmit->cMun);
				$dadosEmitente = [
					'cpf' => $xml->NFe->infNFe->emit->CPF,
					'cnpj' => $xml->NFe->infNFe->emit->CNPJ,  				
					'razaoSocial' => $xml->NFe->infNFe->emit->xNome, 				
					'nomeFantasia' => $xml->NFe->infNFe->emit->xFant,
					'logradouro' => $xml->NFe->infNFe->emit->enderEmit->xLgr,
					'numero' => $xml->NFe->infNFe->emit->enderEmit->nro,
					'bairro' => $xml->NFe->infNFe->emit->enderEmit->xBairro,
					'cep' => $xml->NFe->infNFe->emit->enderEmit->CEP,
					'fone' => $xml->NFe->infNFe->emit->enderEmit->fone,
					'ie' => $xml->NFe->infNFe->emit->IE,
					'cidade_id' => $cidade->id
				];

				$vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete, 
					2, ",", ".");

				$vDesc = $xml->NFe->infNFe->total->ICMSTot->vDesc;


				$idFornecedor = 0;
				$fornecedorEncontrado = $this->verificaFornecedor($dadosEmitente['cnpj']);
				$dadosAtualizados = [];
				if($fornecedorEncontrado){
					$idFornecedor = $fornecedorEncontrado->id;
					$dadosAtualizados = $this->verificaAtualizacao($fornecedorEncontrado, $dadosEmitente);
				}else{

					array_push($dadosAtualizados, "Fornecedor cadastrado com sucesso");
					$idFornecedor = $this->cadastrarFornecedor($dadosEmitente);
				}

			//Produtos

			//itens
				$seq = 0;
				$itens = [];
				$contSemRegistro = 0;
				foreach($xml->NFe->infNFe->det as $item) {

					$produto = Produto::verificaCadastrado($item->prod->cEAN,
						$item->prod->xProd, $item->prod->cProd);

					$produtoNovo = !$produto ? true : false;
					$codSiad = 0;
					if($produtoNovo){ 
						$contSemRegistro++;
					}
					else{
						$i = ItemCompra::
						where('produto_id', $produto->id)
						->first();
						if($i != null){
							$codSiad = $i->codigo_siad ?? 0;
						}
					}

					$item = [
						'codigo' => $item->prod->cProd,
						'xProd' => $item->prod->xProd,
						'NCM' => $item->prod->NCM,
						'CFOP' => $item->prod->CFOP,
						'CFOP_entrada' => $this->getCfopEntrada($item->prod->CFOP),
						'uCom' => $item->prod->uCom,
						'vUnCom' => $item->prod->vUnCom,
						'qCom' => $item->prod->qCom,
						'codBarras' => $item->prod->cEAN,
						'produtoNovo' => $produtoNovo,
						'codSiad' => $codSiad,
						'produtoId' => $produtoNovo ? '0' : $produto->id,
						'conversao_unitaria' => $produtoNovo ? '' : $produto->conversao_unitaria
					];
					array_push($itens, $item);
				}
				
				$chave = substr($xml->NFe->infNFe->attributes()->Id, 3, 44);
				$dadosNf = [
					'chave' => $chave,
					'vProd' => $xml->NFe->infNFe->total->ICMSTot->vProd,
					'indPag' => $xml->NFe->infNFe->ide->indPag,
					'nNf' => $xml->NFe->infNFe->ide->nNF,
					'vFrete' => $vFrete,
					'vDesc' => $vDesc,
					'contSemRegistro' => $contSemRegistro,
					
				];


			//Pagamento
				$fatura = [];
				if (!empty($xml->NFe->infNFe->cobr->dup))
				{
					foreach($xml->NFe->infNFe->cobr->dup as $dup) {
						$titulo = $dup->nDup;
						$vencimento = $dup->dVenc;
						$vencimento = explode('-', $vencimento);
						$vencimento = $vencimento[2]."/".$vencimento[1]."/".$vencimento[0];
						$vlr_parcela = number_format((double) $dup->vDup, 2, ",", ".");	

						$parcela = [
							'numero' => $titulo,
							'vencimento' => $vencimento,
							'valor_parcela' => $vlr_parcela
						];
						array_push($fatura, $parcela);
					}
				}

			//upload
				$file = $request->file;
				$nameArchive = $chave . ".xml" ;

				$pathXml = $file->move(public_path('xml_entrada'), $nameArchive);

            //fim upload

				$categorias = Categoria::
				where('empresa_id', $this->empresa_id)
				->get();
				$unidadesDeMedida = Produto::unidadesMedida();

				$listaCSTCSOSN = Produto::listaCSTCSOSN();
				$listaCST_PIS_COFINS = Produto::listaCST_PIS_COFINS();
				$listaCST_IPI = Produto::listaCST_IPI();
				
				$config = ConfigNota::
				where('empresa_id', $this->empresa_id)
				->first();

				return view('compraFiscal/visualizaNota')
				->with('title', 'Nota Fiscal')
				->with('itens', $itens)
				->with('fatura', $fatura)
				->with('pathXml', $nameArchive)
				->with('compraFiscalJs', true)
				->with('idFornecedor', $idFornecedor)
				->with('dadosNf', $dadosNf)
				->with('listaCSTCSOSN', $listaCSTCSOSN)
				->with('listaCST_PIS_COFINS', $listaCST_PIS_COFINS)
				->with('listaCST_IPI', $listaCST_IPI)
				->with('config', $config)
				->with('unidadesDeMedida', $unidadesDeMedida)
				->with('categorias', $categorias)
				->with('dadosEmitente', $dadosEmitente)
				->with('dadosAtualizados', $dadosAtualizados);
			}else{
				session()->flash('mensagem_erro', $msgImport);
				return redirect("/compraFiscal");
			}

		}else{
			session()->flash('mensagem_erro', 'XML inválido!');
			return redirect("/compraFiscal");
		}

	}


	private function getCfopEntrada($cfop){
		$natureza = NaturezaOperacao::
		where('empresa_id', $this->empresa_id)
		->where('CFOP_saida_estadual', $cfop)
		->first();

		if($natureza != null){
			return $natureza->CFOP_entrada_inter_estadual;
		}

		$natureza = NaturezaOperacao::
		where('empresa_id', $this->empresa_id)
		->where('CFOP_saida_inter_estadual', $cfop)
		->first();

		if($natureza != null){
			return $natureza->CFOP_entrada_inter_estadual;
		}

		$digito = substr($cfop, 0, 1);
		if($digito == '5'){
			return '1'. substr($cfop, 1, 4);

		}else{
			return '2'. substr($cfop, 1, 4);
		}
	}

	private function verificaFornecedor($cnpj){
		$forn = Fornecedor::verificaCadastrado($this->formataCnpj($cnpj));
		return $forn;
	}

	private function verificaAtualizacao($fornecedorEncontrado, $dadosEmitente){
		$dadosAtualizados = [];

		$verifica = $this->dadosAtualizados('Razao Social', $fornecedorEncontrado->razao_social,
			$dadosEmitente['razaoSocial']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$verifica = $this->dadosAtualizados('Nome Fantasia', $fornecedorEncontrado->nome_fantasia,
			$dadosEmitente['nomeFantasia']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$verifica = $this->dadosAtualizados('Rua', $fornecedorEncontrado->rua,
			$dadosEmitente['logradouro']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$verifica = $this->dadosAtualizados('Numero', $fornecedorEncontrado->numero,
			$dadosEmitente['numero']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$verifica = $this->dadosAtualizados('Bairro', $fornecedorEncontrado->bairro,
			$dadosEmitente['bairro']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$verifica = $this->dadosAtualizados('IE', $fornecedorEncontrado->ie_rg,
			$dadosEmitente['ie']);
		if($verifica) array_push($dadosAtualizados, $verifica);

		$this->atualizar($fornecedorEncontrado, $dadosEmitente);
		return $dadosAtualizados;
	}

	private function atualizar($fornecedor, $dadosEmitente){
		$fornecedor->razao_social = $dadosEmitente['razaoSocial'];
		$fornecedor->nome_fantasia = $dadosEmitente['nomeFantasia'];
		$fornecedor->rua = $dadosEmitente['logradouro'];
		$fornecedor->ie_rg = $dadosEmitente['ie'];
		$fornecedor->bairro = $dadosEmitente['bairro'];
		$fornecedor->numero = $dadosEmitente['numero'];
		$fornecedor->save();
	}

	private function dadosAtualizados($campo, $anterior, $atual){
		if($anterior != $atual){
			return $campo . " atualizado";
		} 
		return false;
	}


	private function cadastrarFornecedor($fornecedor){
		
		$result = Fornecedor::create([
			'razao_social' => $fornecedor['razaoSocial'],
			'nome_fantasia' => $fornecedor['nomeFantasia'],
			'rua' => $fornecedor['logradouro'],
			'numero' => $fornecedor['numero'],
			'bairro' => $fornecedor['bairro'],
			'cep' => $this->formataCep($fornecedor['cep']),
			'cpf_cnpj' => $this->formataCnpj($fornecedor['cnpj']),
			'ie_rg' => $fornecedor['ie'],
			'celular' => '*',
			'telefone' => $this->formataTelefone($fornecedor['fone']),
			'email' => '*',
			'cidade_id' => $fornecedor['cidade_id'],
			'empresa_id' => $this->empresa_id
		]);
		return $result->id;
	}

	private function formataCnpj($cnpj){
		$temp = substr($cnpj, 0, 2);
		$temp .= ".".substr($cnpj, 2, 3);
		$temp .= ".".substr($cnpj, 5, 3);
		$temp .= "/".substr($cnpj, 8, 4);
		$temp .= "-".substr($cnpj, 12, 2);
		return $temp;
	}

	private function formataCep($cep){
		$temp = substr($cep, 0, 5);
		$temp .= "-".substr($cep, 5, 3);
		return $temp;
	}

	private function formataTelefone($fone){
		$temp = substr($fone, 0, 2);
		$temp .= " ".substr($fone, 2, 4);
		$temp .= "-".substr($fone, 4, 4);
		return $temp;
	}

	public function salvarNfFiscal(Request $request){
		$nf = $request->nf;

		$result = Compra::create([
			'fornecedor_id' => $nf['fornecedor_id'],
			'usuario_id' => get_id_user(),
			'nf' => $nf['nNf'],
			'observacao' => $nf['observacao'],
			'valor' => str_replace(",", ".", $nf['valor_nf']),
			'desconto' => str_replace(",", ".", $nf['desconto']),
			'xml_path' => $nf['xml_path'],
			'estado' => 'NOVO',
			'numero_emissao' => 0,
		//'categoria_id' => 1,
			'chave' => $nf['chave'],
			'empresa_id' => $this->empresa_id 
		]);

		echo json_encode($result);
	}

	public function salvarItem(Request $request){
		$prod = $request->produto;

		$produtoBD = Produto::
		where('id', (int) $prod['produto_id'])
		->where('empresa_id', $this->empresa_id)
		->first();

		$result = ItemCompra::create([
			'compra_id' => (int) $prod['compra_id'],
			'produto_id' => (int) $prod['produto_id'],
			'quantidade' =>  str_replace(",", ".", $prod['quantidade']),
			'valor_unitario' => str_replace(",", ".", $prod['valor']),
			'unidade_compra' => $prod['unidade'],
			'cfop_entrada' => $prod['cfop_entrada'],
			'codigo_siad' => $prod['said'] ?? ''
		]);

		$valor = $produtoBD->valor_venda > 0 ? $produtoBD->valor_venda : $prod['valor'];
		$stockMove = new StockMove();
		$stockMove->pluStock((int) $prod['produto_id'], 
			str_replace(",", ".", $prod['quantidade'] * $produtoBD->conversao_unitaria),
			str_replace(",", ".", $valor));

		echo json_encode($result);
	}

}
