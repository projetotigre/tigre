<?php

class ConveniosController extends \BaseController
{

    protected $convenio;

    /**
     * [__construct description]
     */
    public function __construct(Convenio $convenio)
    {
        $this->convenio = $convenio;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $ano  = Input::get('ano', date('Y')); //get the parameter
        $natureza_juridica_id = Input::get('natureza_juridica_id');

        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $ano.'-01-01'); //convert in a carbon date


        $query_convenio = $this->convenio

            ->join('proponentes', 'proponentes.id', '=', 'convenios.contrato_id')

            ->where('data_inicio_vigencia', '>', $date->format('Y-m-d'))
            ->where('data_inicio_vigencia', '<', $date->addYear()->format('Y-m-d'));


        if(!empty($natureza_juridica_id))
        {
            $query_convenio->where('natureza_juridica_id', $natureza_juridica_id);
        }

        return $query_convenio->get();

    }

}
