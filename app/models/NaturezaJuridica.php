<?php

class NaturezaJuridica extends \Eloquent
{

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'naturezas_juridicas';


	protected $fillable = [
		'siconv_id',
		'nome'
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
