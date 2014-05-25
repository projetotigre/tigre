<?php

class ConveniosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Convenio::where('data_inicio_vigencia', '>' ,'2012-01-01')->first();
	}

}
