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
		Schema::create('proponentes', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('siconv_id')->index()->unique();
			$table->string('cnpj')->index()->unique();
			$table->string('nome');
			$table->integer('esfera_administrativa_id')->index();
			$table->integer('municipio_id')->index();
			$table->string('endereco');
			$table->string('cep');
			$table->integer('pessoa_responsavel_id')->index();
			$table->string('cpf_responsavel');
			$table->string('nome_responsavel');
			$table->string('telefone');
			$table->string('fax');
			$table->integer('natureza_juridica_id')->index();
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
		Schema::drop('proponentes');
	}

}
