<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLatLngToProponentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('proponentes', function(Blueprint $table) {
            $table->double('longitude')->after('inscricao_municipal');
            $table->double('latitude')->after('inscricao_municipal');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('proponentes', function(Blueprint $table) {
            $table->dropColumn('longitude', 'latitude');
		});
	}

}
