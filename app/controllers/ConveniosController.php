<?php

class ConveniosController extends \BaseController
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $ano  = Input::get('ano', date('Y')); //get the parameter
        $data = \Carbon\Carbon::createFromFormat('Y-m-d', $ano.'-01-01'); //convert in a carbon date
        $query_convenio     =   Convenio::where('data_inicio_vigencia', '>=' ,$data)
                                    ->orWhere('data_inicio_vigencia', '<=' ,$data->addYear());

        $natureza_juridica_id    = Input::get('natureza_juridica_id', '');

        if(!empty($natureza_juridica_id)
        {
            $query_convenio->where('natureza_juridica_id', $natureza_juridica_id);
        }

        return $query_convenio->get();
    }

}
