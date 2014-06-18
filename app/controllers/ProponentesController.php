<?php

use Dingo\Api\Dispatcher;
use Dingo\Api\Auth\Shield;

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
    public function __construct(Dispatcher $api, Shield $auth, Proponente $proponente)
    {
        parent::__construct($api, $auth);

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
