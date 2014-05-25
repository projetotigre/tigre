<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('convenios', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('contrato_id')->unique();
			$table->string('modalidade');
			$table->integer('id_orgao');
			$table->string('justificativa_resumida');
			$table->string('objeto_resumido');
			$table->date('data_inicio_vigencia');
			$table->date('data_fim_vigencia');
			$table->double('valor_global');
			$table->double('valor_repasse_uniao');
			$table->double('valor_contrapartida');
			$table->date('data_assinatura')->nullable();
			$table->date('data_publicacao')->nullable();
			$table->integer('id_situacao_convenio');
			$table->integer('proponente_id');

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
		Schema::drop('convenios');
	}
}
