<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Estoque;
use App\Categoria;
use App\ConfigNota;
use App\Tributacao;
use App\Rules\EAN13;
use App\Helpers\StockMove;
use App\CategoriaProdutoDelivery;
use App\ProdutoDelivery;
use App\ProdutoListaPreco;
use App\ImagensProdutoDelivery;
use App\ItemDfe;

class ProductController extends Controller
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
        $produtos = Produto::
        where('empresa_id', $this->empresa_id)
        ->paginate(15);

        $categorias = Categoria:: 
        where('empresa_id', $this->empresa_id)
        ->get();

        $produtos = $this->setaEstoque($produtos);

        return view('produtos/list')
        ->with('produtos', $produtos)
        ->with('links', true)
        ->with('categorias', $categorias)
        ->with('title', 'Produtos');
    }

    private function setaEstoque($produtos){
        foreach($produtos as $p){
            $estoque = Estoque::where('produto_id', $p->id)->first();
            $p->estoque_atual = $estoque == null ? 0 : $estoque->quantidade;
        }
        return $produtos;
    }

    public function new(Request $request){
        $categoria = Categoria::
        where('empresa_id', $request->empresa_id)
        ->first();
        if($categoria == null){
            //nao tem categoria
            session()->flash('mensagem_erro', 'Cadastre ao menos uma categoria!');
            return redirect('/categorias');
        }
        $anps = Produto::lista_ANP();
        $natureza = Produto::
        firstNatureza($request->empresa_id);

        if($natureza == null){

            session()->flash('mensagem_erro', 'Cadastre uma natureza de operação!');
            return redirect('/naturezaOperacao');
        }

        $categorias = Categoria::
        where('empresa_id', $request->empresa_id)
        ->get();

        $categoriasDelivery = CategoriaProdutoDelivery::
        where('empresa_id', $request->empresa_id)
        ->get();

        $listaCSTCSOSN = Produto::listaCSTCSOSN();
        $listaCST_PIS_COFINS = Produto::listaCST_PIS_COFINS();
        $listaCST_IPI = Produto::listaCST_IPI();
        $tributacao = Tributacao::
        where('empresa_id', $request->empresa_id)
        ->first();

        if($tributacao == null){

            session()->flash('mensagem_erro', 'Informe a tributação padrão!');
            return redirect('tributos');
        }

        $unidadesDeMedida = Produto::unidadesMedida();
        $config = ConfigNota::
        where('empresa_id', $request->empresa_id)
        ->first();
        
        return view('produtos/register')
        ->with('categorias', $categorias)
        ->with('unidadesDeMedida', $unidadesDeMedida)
        ->with('listaCSTCSOSN', $listaCSTCSOSN)
        ->with('listaCST_PIS_COFINS', $listaCST_PIS_COFINS)
        ->with('listaCST_IPI', $listaCST_IPI)
        ->with('anps', $anps)
        ->with('config', $config)
        ->with('tributacao', $tributacao)
        ->with('natureza', $natureza)
        ->with('categoriasDelivery', $categoriasDelivery)
        ->with('produtoJs', true)
        ->with('title', 'Cadastrar Produto');
    }

    public function save(Request $request){
        $produto = new Produto();

        $anps = Produto::lista_ANP();
        $descAnp = '';

        foreach($anps as $key => $a){
            if($key == $request->anp){
                $descAnp = $a;
            }
        }

        $request->merge([ 'composto' => $request->input('composto') ? true : false ]);
        $request->merge([ 'valor_livre' => $request->input('valor_livre') ? true : false ]);
        $request->merge([ 'gerenciar_estoque' => $request->input('gerenciar_estoque') ? true : false ]);
        $request->merge([ 'valor_venda' => str_replace(",", ".", $request->input('valor_venda'))]);
        $request->merge([ 'valor_compra' => str_replace(",", ".", $request->input('valor_compra'))]);
        $request->merge([ 'conversao_unitaria' => $request->input('conversao_unitaria') ? 
            $request->input('conversao_unitaria') : 1]);
        $request->merge([ 'codBarras' => $request->input('codBarras') ?? 'SEM GTIN']);
        $request->merge([ 'CST_CSOSN' => $request->input('CST_CSOSN') ?? '0']);
        $request->merge([ 'CST_PIS' => $request->input('CST_PIS') ?? '0']);
        $request->merge([ 'CST_COFINS' => $request->input('CST_COFINS') ?? '0']);
        $request->merge([ 'CST_IPI' => $request->input('CST_IPI') ?? '0']);
        $request->merge([ 'codigo_anp' => $request->anp != '' ? $request->anp : '']);
        $request->merge([ 'descricao_anp' => $request->anp != '' ? $descAnp : '']);
        $request->merge([ 'descricao_anp' => $request->anp != '' ? $descAnp : '']);
        $request->merge([ 'cListServ' => $request->cListServ ?? '']);
        $request->merge([ 'alerta_vencimento' => $request->alerta_vencimento ?? 0]);
        $request->merge([ 'imagem' => '' ]);
        $request->merge([ 'estoque_minimo' => $request->estoque_minimo ?? 0]);
        $request->merge([ 'referencia' => $request->referencia ?? '']);

        $request->merge([ 'largura' => $request->largura ?? 0]);
        $request->merge([ 'comprimento' => $request->comprimento ?? 0]);
        $request->merge([ 'altura' => $request->altura ?? 0]);
        $request->merge([ 'peso_liquido' => $request->peso_liquido ?? 0]);
        $request->merge([ 'peso_bruto' => $request->peso_bruto ?? 0]);
        $request->merge([ 'limite_maximo_desconto' => $request->limite_maximo_desconto ?? 0]);
        $request->merge([ 'perc_icms' => $request->perc_icms ? __replace($request->perc_icms) : 0]);
        $request->merge([ 'perc_pis' => $request->perc_pis ? __replace($request->perc_pis) : 0]);
        $request->merge([ 'perc_cofins' => $request->perc_cofins ? __replace($request->perc_cofins) : 0]);
        $request->merge([ 'perc_ipi' => $request->perc_ipi ? __replace($request->perc_ipi) : 0]);


        $this->_validate($request);

        $result = $produto->create($request->all());
        $produto = Produto::find($result->id);
        $this->salveImagemProduto($request, $produto); // salva a imagem no produto comum

        if($request->atribuir_delivery){
            $this->salvarProdutoNoDelivery($request, $produto); 
        // salva o produto no delivery
        }

        if($result){

            session()->flash("mensagem_sucesso", "Produto cadastrado com sucesso!");
        }else{

            session()->flash('mensagem_erro', 'Erro ao cadastrar produto!');
        }

        return redirect('/produtos');
    }

    public function edit($id){
        $natureza = Produto::firstNatureza($this->empresa_id);
        $anps = Produto::lista_ANP();

        if($natureza == null){

            session()->flash('mensagem_erro', 'Cadastre uma natureza de operação!');
            return redirect('/naturezaOperacao');
        }

        $produto = new Produto(); 

        $listaCSTCSOSN = Produto::listaCSTCSOSN();
        $listaCST_PIS_COFINS = Produto::listaCST_PIS_COFINS();
        $listaCST_IPI = Produto::listaCST_IPI();

        $categorias = Categoria::
        where('empresa_id', $this->empresa_id)
        ->get();

        $unidadesDeMedida = Produto::unidadesMedida();
        $config = ConfigNota::
        where('empresa_id', $this->empresa_id)
        ->first();

        $tributacao = Tributacao::
        where('empresa_id', $this->empresa_id)
        ->first();

        $resp = $produto
        ->where('id', $id)->first();  

        $categoriasDelivery = CategoriaProdutoDelivery::
        where('empresa_id', $this->empresa_id)
        ->get();

        if($tributacao == null){

            session()->flash('mensagem_erro', 'Informe a tributação padrão!');
            return redirect('tributos');
        }

        if(valida_objeto($resp)){
            return view('produtos/register')
            ->with('produto', $resp)
            ->with('config', $config)
            ->with('tributacao', $tributacao)
            ->with('natureza', $natureza)
            ->with('listaCSTCSOSN', $listaCSTCSOSN)
            ->with('listaCST_PIS_COFINS', $listaCST_PIS_COFINS)
            ->with('listaCST_IPI', $listaCST_IPI)
            ->with('categoriasDelivery', $categoriasDelivery)
            ->with('anps', $anps)
            ->with('unidadesDeMedida', $unidadesDeMedida)
            ->with('categorias', $categorias)
            ->with('produtoJs', true)
            ->with('title', 'Editar Produto');
        }else{
            return redirect('/403');
        }

    }

    private function salveImagemProduto($request, $produto){
        if($request->hasFile('file')){


            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
            //unlink anterior
            if(file_exists($public.'imgs_produtos/'.$produto->imagem) && $produto->imagem != '')
                unlink($public.'imgs_produtos/'.$produto->imagem);

            $file = $request->file('file');

            $extensao = $file->getClientOriginalExtension();
            $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
            
            $upload = $file->move(public_path('imgs_produtos'), $nomeImagem);
            $produto->imagem = $nomeImagem;
            $produto->save();
        }else{

        }
    }

    public function pesquisa(Request $request){
        $pesquisa = $request->input('pesquisa');

        $produtos = Produto::where('nome', 'LIKE', "%$pesquisa%")
        ->where('empresa_id', $request->empresa_id)->get();
        $categorias = Categoria::all();
        $produtos = $this->setaEstoque($produtos);
        
        return view('produtos/list')
        ->with('categorias', $categorias)
        ->with('produtos', $produtos)
        ->with('title', 'Filtro Produto');
    }

    public function filtroCategoria(Request $request){
        $categoria = $request->input('categoria');
        $pesquisa = $request->input('pesquisa');

        $porCodigoBarras = is_numeric($pesquisa);

        if($porCodigoBarras == 1){
            $query = Produto::where('codBarras', $pesquisa);

        }else{
            $query = Produto::where('nome', 'LIKE', "%$pesquisa%");
        }
        if($categoria != '-'){
            $query = Produto::where('categoria_id', $categoria);
        }

        $query->where('empresa_id', $request->empresa_id);

        $produtos = $query->get();

        $categorias = Categoria::all();

        $categoria = Categoria::find($categoria);
        $produtos = $this->setaEstoque($produtos);

        return view('produtos/list')
        ->with('produtos', $produtos)
        ->with('categorias', $categorias)
        ->with('categoria', $categoria != null ? $categoria->nome : '')
        ->with('title', 'Filtro Produto');
    }

    public function receita($id){
        $resp = Produto::
        where('id', $id)
        ->first();  

        $produtos = Produto::where('empresa_id', $request->empresa_id)->get();

        return view('produtos/receita')
        ->with('produto', $resp)
        ->with('produtos', $produtos)
        ->with('produtoJs', true)
        ->with('title', 'Receita do Produto');

    }

    public function update(Request $request){

        $product = new Produto();

        $id = $request->input('id');
        $resp = $product
        ->where('id', $id)->first(); 

        $this->_validate($request);

        $anps = Produto::lista_ANP();
        $descAnp = '';
        foreach($anps as $key => $a){
            if($key == $request->anp){
                $descAnp = $a;
            }
        }

        $resp->nome = $request->input('nome');
        $resp->categoria_id = $request->input('categoria_id');
        $resp->cor = $request->input('cor');
        $resp->valor_venda = str_replace(",", ".", $request->input('valor_venda'));
        $resp->valor_compra = str_replace(",", ".", $request->input('valor_compra'));
        $resp->NCM = $request->input('NCM');
        $resp->CEST = $request->input('CEST') ?? '';

        $resp->CST_CSOSN = $request->input('CST_CSOSN');
        $resp->CST_PIS = $request->input('CST_PIS');
        $resp->CST_COFINS = $request->input('CST_COFINS');
        $resp->CST_IPI = $request->input('CST_IPI');
        // $resp->CFOP = $request->input('CFOP');
        $resp->unidade_venda = $request->input('unidade_venda');
        $resp->unidade_compra = $request->input('unidade_compra');
        $resp->conversao_unitaria = $request->input('conversao_unitaria') ? $request->input('conversao_unitaria') : $resp->conversao_unitaria;
        $resp->codBarras = $request->input('codBarras') ?? 'SEM GTIN';

        $resp->perc_icms = $request->perc_icms ? __replace($request->perc_icms) : 0;
        $resp->perc_pis = $request->perc_pis ? __replace($request->perc_pis) : 0;
        $resp->perc_cofins = $request->perc_cofins ? __replace($request->perc_cofins) : 0;
        $resp->perc_ipi = $request->perc_ipi ? __replace($request->perc_ipi) : 0;
        $resp->perc_iss = $request->perc_iss ? __replace($request->perc_iss) : 0;
        $resp->cListServ = $request->input('cListServ');

        $resp->CFOP_saida_estadual = $request->input('CFOP_saida_estadual');
        $resp->CFOP_saida_inter_estadual = $request->input('CFOP_saida_inter_estadual');
        $resp->codigo_anp = $request->input('anp') ?? '';
        $resp->descricao_anp = $descAnp;
        $resp->alerta_vencimento = $request->alerta_vencimento;
        $resp->referencia = $request->referencia;

        $resp->composto = $request->composto ? true : false;
        $resp->valor_livre = $request->valor_livre ? true : false;
        $resp->gerenciar_estoque = $request->gerenciar_estoque ? true : false;
        $resp->estoque_minimo = $request->estoque_minimo;

        $resp->largura = $request->largura;
        $resp->comprimento = $request->comprimento;
        $resp->altura = $request->altura;
        $resp->peso_liquido = $request->peso_liquido;
        $resp->peso_bruto = $request->peso_bruto;
        $resp->limite_maximo_desconto = $request->limite_maximo_desconto;

        $result = $resp->save();
        $this->salveImagemProduto($request, $resp);
        if($result){
            if($request->atribuir_delivery){
                $this->updateProdutoNoDelivery($request, $resp);
            }

            session()->flash('mensagem_sucesso', 'Produto editado com sucesso!');
        }else{

            session()->flash('mensagem_erro', 'Erro ao editar produto!');
        }

        return redirect('/produtos'); 
    }

    public function delete($id){
        try{
            $produto = Produto
            ::where('id', $id)
            ->first();

            if(valida_objeto($produto)){

                $public = getenv('SERVIDOR_WEB') ? 'public/' : '';


                if(file_exists($public.'imgs_produtos/'.$produto->imagem) && $produto->imagem != '')
                    unlink($public.'imgs_produtos/'.$produto->imagem);

                $delete = $produto->delete();

                if($delete){
                    session()->flash('mensagem_sucesso', 'Registro removido!');
                }else{

                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/produtos');
            }else{
                return redirect('/403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar produto')
            ->with('motivo', 'Não é possivel remover produtos, presentes vendas, compras ou pedidos!');
        }
    }

    private function _validate(Request $request){
        $rules = [
            'nome' => 'required|max:100',
            'valor_venda' => 'required',
            'valor_compra' => 'required',
            'NCM' => 'required|min:10',
            'perc_icms' => 'required',
            'perc_pis' => 'required',
            'perc_cofins' => 'required',
            'perc_ipi' => 'required',
            'codBarras' => [],
            'CFOP_saida_estadual' => 'required',
            'CFOP_saida_inter_estadual' => 'required',
            'file' => 'max:700',
            // 'CEST' => 'required'
        ];

        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'NCM.required' => 'O campo NCM é obrigatório.',
            'NCM.min' => 'NCM precisa de 8 digitos.',
            // 'CFOP.required' => 'O campo CFOP é obrigatório.',
            'CEST.required' => 'O campo CEST é obrigatório.',
            'valor_venda.required' => 'O campo valor de venda é obrigatório.',
            'valor_compra.required' => 'O campo valor de compra é obrigatório.',
            'nome.max' => '100 caracteres maximos permitidos.',
            'perc_icms.required' => 'O campo %ICMS é obrigatório.',
            'perc_pis.required' => 'O campo %PIS é obrigatório.',
            'perc_cofins.required' => 'O campo %COFINS é obrigatório.',
            'perc_ipi.required' => 'O campo %IPI é obrigatório.',
            'CFOP_saida_estadual.required' => 'Campo obrigatório.',
            'CFOP_saida_inter_estadual.required' => 'Campo obrigatório.',
            'file.max' => 'Arquivo muito grande maximo 300 Kb'

        ];
        $this->validate($request, $rules, $messages);
    }

    public function all(){
        $products = Produto::all();
        $arr = array();
        foreach($products as $p){
            $arr[$p->id. ' - ' .$p->nome . ($p->cor != '--' ? ' | COR: ' . $p->cor : '') . ($p->referencia != '' ? ' | REF: ' . $p->referencia : '')] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function getUnidadesMedida(){
        $unidades = Produto::unidadesMedida();
        echo json_encode($unidades);
    }

    public function composto(){
        $products = Produto::
        where('composto', true)
        ->get();
        $arr = array();
        foreach($products as $p){
            $arr[$p->id. ' - ' .$p->nome . ($p->cor != '--' ? ' | Cor: ' . $p->cor : '') . ($p->referencia != '' ? ' | REF: ' . $p->referencia : '')] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function naoComposto(){
        $products = Produto::
        where('composto', false)
        ->get();
        $arr = array();
        foreach($products as $p){
            $arr[$p->id. ' - ' .$p->nome . ($p->cor != '--' ? ' | Cor: ' . $p->cor : '') . ($p->referencia != '' ? ' | REF: ' . $p->referencia : '')] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function getValue(Request $request){
        $id = $request->input('id');
        $product = Product::
        where('id', $id)
        ->first();
        echo json_encode($product->value_sale);
    }

    public function getProduto($id){
        $produto = Produto::
        where('id', $id)
        ->first();
        if($produto->delivery){
            foreach($produto->delivery->pizza as $tp){
                $tp->tamanho;
            }
        }
        echo json_encode($produto);
    }

    public function getProdutoVenda($id, $listaId){
        $produto = Produto::
        where('id', $id)
        ->first();
        if($produto->delivery){
            foreach($produto->delivery->pizza as $tp){
                $tp->tamanho;
            }
        }

        if($listaId > 0){
            $lista = ProdutoListaPreco::
            where('lista_id', $listaId)
            ->where('produto_id', $produto->id)
            ->first();

            if($lista->valor > 0){
                $produto->valor_venda = (string) $lista->valor;
            }
        }

        $estoque = Estoque::where('produto_id', $id)->first();
        $produto->estoque_atual = $estoque != null ? $estoque->quantidade : 0; 
        echo json_encode($produto);
    }

    public function getProdutoCodBarras($cod){
        $produto = Produto::
        where('codBarras', $cod)
        ->where('empresa_id', $this->empresa_id)
        ->first();

        echo json_encode($produto);
    }

    public function salvarProdutoDaNota(Request $request){
        //echo json_encode($request->produto);
        $produto = $request->produto;
        $natureza = Produto::firstNatureza($this->empresa_id);

        $valorVenda = str_replace(".", "", $produto['valorVenda']);
        $valorVenda = str_replace(",", ".", $valorVenda);

        $valorCompra = $produto['valorCompra'];

        $result = Produto::create([
            'nome' => $produto['nome'],
            'NCM' => $produto['ncm'],
            // 'CFOP' => $produto['cfop'],
            'valor_venda' => $valorVenda,
            'valor_compra' => $produto['valorCompra'],
            'valor_livre' => false,
            'cor' => $produto['cor'],
            'conversao_unitaria' => (int) $produto['conversao_unitaria'],
            'categoria_id' => $produto['categoria_id'],
            'unidade_compra' => $produto['unidadeCompra'],
            'unidade_venda' => $produto['unidadeVenda'],
            'codBarras' => $produto['codBarras'] ?? 'SEM GTIN',
            'composto' => false,
            'CST_CSOSN' => $produto['CST_CSOSN'],
            'CST_PIS' => $produto['CST_PIS'],
            'CST_COFINS' => $produto['CST_COFINS'],        
            'CST_IPI' => $produto['CST_IPI'],
            'perc_icms' => 0,
            'perc_pis' => 0,
            'perc_cofins' => 0,
            'perc_ipi' => 0,
            'CFOP_saida_estadual' => $natureza->CFOP_saida_estadual,
            'CFOP_saida_inter_estadual' => $natureza->CFOP_saida_inter_estadual,
            'codigo_anp' => '', 
            'descricao_anp' => '',
            'cListServ' => '',
            'imagem' => '',
            'alerta_vencimento' => 0,
            'referencia' => $produto['referencia'],
            'empresa_id' => $this->empresa_id,
            'gerenciar_estoque' => getenv("PRODUTO_GERENCIAR_ESTOQUE"),
            'limite_maximo_desconto' => 0
        ]);

        echo json_encode($result);  
    }

    public function salvarProdutoDaNotaComEstoque(Request $request){
        //echo json_encode($request->produto);
        $produto = $request->produto;
        $natureza = Produto::firstNatureza($this->empresa_id);
        $valorVenda = str_replace(",", ".", $produto['valorVenda']);

        $valorCompra = $produto['valorCompra'];

        $result = Produto::create([
            'nome' => $produto['nome'],
            'NCM' => $produto['ncm'],
            'valor_venda' => $valorVenda,
            'valor_compra' => $valorCompra,
            'valor_livre' => false,
            'cor' => $produto['cor'],
            'conversao_unitaria' => (int) $produto['conversao_unitaria'],
            'categoria_id' => $produto['categoria_id'],
            'unidade_compra' => $produto['unidadeCompra'],
            'unidade_venda' => $produto['unidadeVenda'],
            'codBarras' => $produto['codBarras'] ?? 'SEM GTIN',
            'composto' => false,
            'CST_CSOSN' => $produto['CST_CSOSN'],
            'CST_PIS' => $produto['CST_PIS'],
            'CST_COFINS' => $produto['CST_COFINS'],        
            'CST_IPI' => $produto['CST_IPI'],
            'perc_icms' => 0,
            'perc_pis' => 0,
            'perc_cofins' => 0,
            'perc_ipi' => 0,
            'CFOP_saida_estadual' => $natureza->CFOP_saida_estadual,
            'CFOP_saida_inter_estadual' => $natureza->CFOP_saida_inter_estadual,
            'codigo_anp' => '', 
            'descricao_anp' => '',
            'cListServ' => '',
            'imagem' => '',
            'alerta_vencimento' => 0,
            'referencia' => $produto['referencia'],
            'empresa_id' => $this->empresa_id,
            'gerenciar_estoque' => getenv("PRODUTO_GERENCIAR_ESTOQUE"),
            'limite_maximo_desconto' => 0

        ]);

        ItemDfe::create(
            [
                'numero_nfe' => $produto['numero_nfe'],
                'produto_id' => $result->id,
                'empresa_id' => $this->empresa_id
            ]
        );

        $stockMove = new StockMove();
        $stockMove->pluStock($result->id, $produto['quantidade'], $valorCompra);

        echo json_encode($result);  
    }

    public function setEstoque(Request $request){
        $stockMove = new StockMove();
        $stockMove->pluStock($request->produto, $request->quantidade, $request->valor);

        ItemDfe::create(
            [
                'numero_nfe' => $request->numero_nfe,
                'produto_id' => $request->produto,
                'empresa_id' => $this->empresa_id
            ]
        );
        echo json_encode("ok");  
    }

    private function salvarProdutoNoDelivery($request, $produto){
        $this->_validateDelivery($request);

        $categoria = CategoriaProdutoDelivery::
        where('id', $request->categoria_delivery_id)
        ->first();

        $valor = 0;
        if(strpos($categoria->nome, 'izza') !== false){
            //pizza nao seta valor por aqui
        }else{
            $valor = str_replace(",", ".", $request->valor_venda);
        }

        $produtoDelivery = [
            'status' => 1 ,
            'produto_id' => $produto->id,
            'destaque' => $request->input('destaque') ? true : false,
            'descricao' => $request->descricao ?? '',
            'ingredientes' => $request->ingredientes ?? '',
            'limite_diario' => $request->limite_diario,
            'categoria_id' => $categoria->id,
            'valor' => $valor,
            'valor_anterior' => 0,
            'empresa_id' => $this->empresa_id
        ];

        $result = ProdutoDelivery::create($produtoDelivery);
        $produtoDelivery = ProdutoDelivery::find($result->id);
        if($result){
            $this->salveImagemProdutoDelivery($request, $produtoDelivery);
        }

    }

    private function updateProdutoNoDelivery($request, $produto){
        // $this->_validateDelivery($request);
        $produtoDelivery = $produto->delivery;
        if($produtoDelivery){
            $catPizza = false;
            $categoria = CategoriaProdutoDelivery::
            where('id', $request->categoria_delivery_id)
            ->first();

            $valor = 0;
            if($categoria && strpos($categoria->nome, 'izza') !== false){

            }else{
                $valor = str_replace(",", ".", $request->valor_venda);
            }

            $produtoDelivery->destaque = $request->input('destaque') ? true : false;
            $produtoDelivery->descricao = $request->input('descricao') ?? $produtoDelivery->descricao;
            $produtoDelivery->ingredientes = $request->input('ingredientes') ?? $produtoDelivery->ingredientes;
            $produtoDelivery->limite_diario = $request->input('limite_diario') ?? $produtoDelivery->limite_diario;
            $produtoDelivery->categoria_id = $request->input('categoria_delivery_id') ?? $produtoDelivery->categoria_delivery_id;
            $produtoDelivery->valor = $request->input('valor') ?? $valor;

            $result = $produtoDelivery->save();

            if($result){
                $this->salveImagemProdutoDelivery($request, $produtoDelivery);
            }
        }else{
            $this->salvarProdutoNoDelivery($request, $produto);
        }

    }

    private function _validateDelivery(Request $request){
        $rules = [
            'ingredientes' => 'max:255',
            'descricao' => 'max:255',
            'limite_diario' => 'required'
        ];

        $messages = [
            'ingredientes.required' => 'O campo ingredientes é obrigatório.',
            'ingredientes.max' => '255 caracteres maximos permitidos.',
            'descricao.required' => 'O campo descricao é obrigatório.',
            'descricao.max' => '255 caracteres maximos permitidos.',
            'limite_diario.required' => 'O campo limite diário é obrigatório'
        ];

        $this->validate($request, $rules, $messages);
    }

    private function salveImagemProdutoDelivery($request, $produtoDelivery){
        if($request->hasFile('file')){
            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';

            $file = $request->file('file');

            $extensao = $file->getClientOriginalExtension();
            $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;

            // $upload = $file->move(public_path('imagens_produtos'), $nomeImagem);
            // if(file_exists($public.'imgs_produtos/'.$nomeImagem)){
            copy($public.'imgs_produtos/'.$nomeImagem, $public.'imagens_produtos/'.$nomeImagem);
            // }else{
            //     $file->move(public_path('imagens_produtos'), $nomeImagem);
            // }

            if(sizeof($produtoDelivery->galeria) == 0){
                //cadastrar
                ImagensProdutoDelivery::create(
                    [
                        'produto_id' => $produtoDelivery->id,
                        'path' => $nomeImagem
                    ]
                );
            }else{
                //ja tem
                $galeria = $produtoDelivery->galeria[0];
                $galeria->path = $nomeImagem;
                $galeria->save();
            }

        }else{

        }
    }

}
