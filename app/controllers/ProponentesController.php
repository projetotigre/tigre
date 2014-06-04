<?php

class ProponentesController extends \BaseController {

	/**
     * $proponente resource
     * @var Proponente
     */
    protected $proponente;

    /**
     * Inject dependencies by constructor
     *
     */
    public function __construct(Proponente $proponente)
    {
        parent::__construct();

        $this->proponente = $proponente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response Json
     */
    public function index()
    {
        return $this->proponente->paginate($this->limit);
    }
}
