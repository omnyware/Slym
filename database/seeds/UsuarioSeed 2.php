<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use App\Empresa;
use App\Helpers\Menu;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function validaPermissao(){
        $menu = new Menu();
        $temp = [];
        $menu = $menu->getMenu();
        foreach($menu as $m){
            foreach($m['subs'] as $s){
                array_push($temp, $s['rota']);
            }
        }
        return $temp;
    }

    public function run()
    {
        Empresa::create([
            'nome' => 'Slym',
            'rua' => 'Aldo ribas',
            'numero' => '190',
            'bairro' => 'Centro',
            'cidade' => 'Jaguariaiva',
            'status' => 1,
            'email' => 'master@master.com',
            'telefone' => '00000000000'
        ]);

        $todasPermissoes = $this->validaPermissao();

        Usuario::create([
        	'nome' => 'Usuário',
        	'login' => 'usuario',
        	'senha' => '202cb962ac59075b964b07152d234b70',
            'adm' => 1,
            'ativo' => 1,
            'permissao' => json_encode($todasPermissoes),
            'empresa_id' => 1,
            'img' => ''
        ]);

        //  Empresa::create([
        //     'nome' => 'Slym2',
        //     'rua' => 'Aldo ribas',
        //     'numero' => '190',
        //     'bairro' => 'Centro',
        //     'cidade' => 'Jaguariaiva'
        // ]);

        // Usuario::create([
        //     'nome' => 'Usuário2',
        //     'login' => 'usuario2',
        //     'senha' => '202cb962ac59075b964b07152d234b70',
        //     'adm' => 1,
        //     'ativo' => 1,
        //     'acesso_cliente' => 1,
        //     'acesso_fornecedor' => 1,
        //     'acesso_produto' => 1,
        //     'acesso_financeiro' => 1,
        //     'acesso_caixa' => 1,
        //     'acesso_estoque' => 1,
        //     'acesso_compra' => 1,
        //     'acesso_fiscal' => 1,
        //     'empresa_id' => 2
        // ]);
    }
}
