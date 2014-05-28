<?php

class Proponente extends \Eloquent
{
	protected $fillable = [
		'cnpj',
		'nome',
		'esfera_administrativa_id',
		'municipio_id',
		'endereco',
		'cep',
		'pessoa_responsavel_id',
		'cpf_responsavel',
		'nome_responsavel',
		'telefone',
		'fax',
		'natureza_juridica_id',
		'inscricao_estadual',
		'inscricao_municipal',
	];


    public function area_atuacao()
    {
        return $this->belongsTo('AreaAtuacaoProponente');
    }
}
