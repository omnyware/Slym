<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	protected $fillable = [
		'nome', 'rua', 'numero', 'bairro', 'cidade', 'telefone', 'email', 'status', 'cnpj', 'permissao'
	];

	public static function getId(){
		$value = session('user_logged');
		return $value['empresa'];
	}

	public function status(){
		$usuario = $this->usuarios[0];
		$value = session('user_logged');


		if($usuario->login == getenv("USERMASTER")){
			return -1;
		}

		if($this->status == 0){
			return 0;
		} 
		else if(!$this->planoEmpresa){
			return 0;
		}else{
			return 1;
		}
	}

	public function usuarioFirst(){
		return $this->hasOne('App\Usuario', 'empresa_id', 'id');
	}

	public function usuarios(){
		return $this->hasMany('App\Usuario', 'empresa_id', 'id');
	}

	public function clientes(){
		return $this->hasMany('App\Cliente', 'empresa_id', 'id');
	}

	public function fornecedores(){
		return $this->hasMany('App\Fornecedor', 'empresa_id', 'id');
	}

	public function produtos(){
		return $this->hasMany('App\Produto', 'empresa_id', 'id');
	}

	public function veiculos(){
		return $this->hasMany('App\Veiculo', 'empresa_id', 'id');
	}

	public function vendas(){
		return $this->hasMany('App\Venda', 'empresa_id', 'id');
	}

	public function vendasCaixa(){
		return $this->hasMany('App\VendaCaixa', 'empresa_id', 'id');
	}

	public function cte(){
		return $this->hasMany('App\Cte', 'empresa_id', 'id');
	}

	public function mdfe(){
		return $this->hasMany('App\Mdfe', 'empresa_id', 'id');
	}

	public function nfes(){
		$vendas = $this->vendas;
		$cont = 0;
		foreach($vendas as $v){
			if($v->NfNumero > 0) $cont++;
		}
		return $cont;
	}

	public function nfces(){
		$vendas = $this->vendasCaixa;
		$cont = 0;
		foreach($vendas as $v){
			if($v->NFcNumero > 0) $cont++;
		}
		return $cont;
	}

	public function ctes(){
		$ct = $this->cte;
		$cont = 0;
		foreach($ct as $c){
			if($c->cte_numero > 0) $cont++;
		}
		return $cont;
	}

	public function mdfes(){
		$md = $this->mdfe;
		$cont = 0;
		foreach($md as $m){
			if($m->mdfe_numero > 0) $cont++;
		}
		return $cont;
	}

	public function planoEmpresa(){
		return $this->hasOne('App\PlanoEmpresa', 'empresa_id', 'id');
	}
}
