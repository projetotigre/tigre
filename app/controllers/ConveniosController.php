<?php

class ConveniosController extends \BaseController
{

    /**
     * $convenio resource
     * @var Convenio
     */
    protected $convenio;

    /**
     * Inject dependencies by constructor
     */
    public function __construct(Convenio $convenio)
    {
        $this->convenio = $convenio;
    }

	/**
	 * Return listing of the resource.
	 *
	 * @return Response Json
	 */
	public function index()
	{
        $ano  = Input::get('ano', date('Y')); //get the parameter
        $natureza_juridica_id = Input::get('natureza_juridica');

        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $ano.'-01-01'); //convert in a carbon date


        $query_convenio = $this->convenio

            ->join('proponentes', 'convenios.proponente_id', '=', 'proponentes.siconv_id')
            ->join('municipios', 'proponentes.municipio_id', '=', 'municipios.municipio_id')
            ->join('naturezas_juridicas', 'proponentes.natureza_juridica_id', '=', 'naturezas_juridicas.siconv_id')

            ->where('data_inicio_vigencia', '>', $date->format('Y-m-d'))
            ->where('data_inicio_vigencia', '<', $date->addYear()->format('Y-m-d'));


        if(!empty($natureza_juridica_id))
        {
            $query_convenio->where('proponentes.natureza_juridica_id', $natureza_juridica_id);
        }


        return Response::json([
            'meta' => [
                'total_itens' => $query_convenio->count(),
                'valor_total' => $query_convenio->sum('valor_repasse_uniao'),
            ],

            'organizacoes' => $query_convenio->select([
                'proponentes.*',
                'convenios.valor_repasse_uniao',
                'municipios.uf_nome as estado',
                'municipios.nome as cidade',
            ])->get()->toArray()
        ]);
    }

}
