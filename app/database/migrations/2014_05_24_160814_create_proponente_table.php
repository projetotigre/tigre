<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProponenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proponente', function(Blueprint $table) {
			$table->increments('id');
			$table->string('cnpj');
			$table->string('nome');
			$table->integer('esfera_administrativa_id');
			$table->integer('municipio_id');
			$table->string('endereco');
			$table->string('cep');
			$table->integer('pessoa_responsavel_id');
			$table->string('cpf_responsavel');
			$table->string('nome_responsavel');
			$table->string('telefone');
			$table->string('fax');
			$table->integer('natureza_juridica');
			$table->string('inscricao_estadual');
			$table->string('inscricao_municipal');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proponente');
	}

}
