<?php

class AreaAtuacaoProponente extends \Eloquent 
{

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'areas_atuacao_proponente';


	protected $fillable = [	
		'id_siconv',
		'descricao'
	];
}