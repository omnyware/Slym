<?php

use Illuminate\Database\Seeder;
use App\Cidade;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call('UsuarioSeed');
        $this->call('CategoriaSeed');
    	$this->call('CidadeSeed');
    }
}
