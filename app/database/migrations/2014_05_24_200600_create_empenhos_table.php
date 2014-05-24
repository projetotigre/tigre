<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmpenhosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empenhos', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('empenho_id')->unique();
			$table->string('numero');
			$table->integer('especie_id');
			$table->integer('convenio_id');
			$table->integer('cod_unidade_gestora_emitente');
			$table->integer('cod_unidade_gestora_referencia');
			$table->integer('cod_unidade_gestora_responsavel');
			$table->integer('cod_gestao_emitente');
			$table->integer('cod_gestao_referencia');
			$table->integer('cod_fonte_recurso');
			$table->string('numero_plano_trabalho_resumido');
			$table->string('numero_plano_interno');
			$table->string('esfera_orcamentaria');
			$table->date('data_emissao');
			$table->string('numero_interno_concedente');
			$table->string('numero_interno_concedente_referencia');
			$table->string('observacao');
			$table->string('situacao');
			$table->string('numero_lista');
			$table->integer('cod_unidade_orcamentaria');
			$table->string('subitem_natureza_despesa_descricao');
			$table->integer('subitem_natureza_despesa_numero');
			$table->double('valor');
			$table->string('numero_empenho_referencia');

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
		Schema::drop('empenhos');
	}
}
