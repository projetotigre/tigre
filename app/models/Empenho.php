<?php

class Empenho extends \Eloquent
{
	protected $fillable = [
		'empenho_id',
		'numero',
		'especie_id',
		'convenio_id',
		'cod_unidade_gestora_emitente',
		'cod_unidade_gestora_referencia',
		'cod_unidade_gestora_responsavel',
		'cod_gestao_emitente',
		'cod_gestao_referencia',
		'cod_fonte_recurso',
		'numero_plano_trabalho_resumido',
		'numero_plano_interno',
		'esfera_orcamentaria',
		'data_emissao',
		'numero_interno_concedente',
		'numero_interno_concedente_referencia',
		'observacao',
		'situacao',
		'numero_lista',
		'cod_unidade_orcamentaria',
		'subitem_natureza_despesa_descricao',
		'subitem_natureza_despesa_numero',
		'valor',
		'numero_empenho_referencia',
	];
}
