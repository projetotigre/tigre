
<?php

class Convenio extends \Eloquent
{
	protected $fillable = array(
		'contrato_id',
		'modalidade',
		'id_orgao',
		'justificativa_resumida',
		'objeto_resumido',
		'data_inicio_vigencia',
		'data_fim_vigencia',
		'valor_global',
		'valor_repasse_uniao',
		'valor_contrapartida',
		'data_assinatura',
		'data_publicacao',
		'id_situacao_convenio',
		'proponente_id',
	);
}
