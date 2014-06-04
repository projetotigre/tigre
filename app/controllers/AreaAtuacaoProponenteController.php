<?php

class AreaAtuacaoProponenteController extends \BaseController {


    /**
     * $area_atuacao resource
     * @var AreaAtuacaoProponente
     */
    protected $area_atuacao;

    /**
     * Inject dependencies by constructor
     *
     */
    public function __construct(AreaAtuacaoProponente $area_atuacao)
    {
        parent::__construct();

        $this->area_atuacao = $area_atuacao;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response Json
	 */
	public function index()
	{
		return $this->area_atuacao->paginate($this->limit);
	}
}
