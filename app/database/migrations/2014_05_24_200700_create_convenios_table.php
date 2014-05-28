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
			$table->float('valor_global',11,2);
			$table->float('valor_repasse_uniao',11,2);
			$table->float('valor_contrapartida',11,2);
			$table->date('data_assinatura')->nullable();
			$table->date('data_publicacao')->nullable();
			$table->integer('id_situacao_convenio');
			$table->string('proponente_id')->index();

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
