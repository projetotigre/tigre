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

    public function getAll()
    {
        return $this->whereNotIn('id', array(1, 2, 3))
                ->orderBy('id','desc')
                ->get();
    }
}
