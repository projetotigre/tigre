<?php

class Municipio extends \Eloquent 
{
	protected $fillable = [	
		'municipio_id',
		'nome',
		'regiao_nome',
		'regiao_sigla',
		'uf_nome',
		'uf_sigla',
	];
}