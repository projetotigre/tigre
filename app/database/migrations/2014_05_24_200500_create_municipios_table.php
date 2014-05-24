<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMunicipiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('municipios', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('municipio_id')->unique();
			$table->string('nome');
			$table->string('regiao_nome');
			$table->string('regiao_sigla');
			$table->string('uf_nome');
			$table->string('uf_sigla');
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
		Schema::drop('municipios');
	}
}
