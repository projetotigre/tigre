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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
