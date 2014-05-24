<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableAreasAtuacaoProponentes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas_atuacao_proponente', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('id_siconv')->index()->unique();
			$table->string('descricao');
			
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
		Schema::drop('areas_atuacao_proponente');
	}
}
