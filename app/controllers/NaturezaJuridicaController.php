<?php

class NaturezaJuridicaController extends \BaseController
{
    /**
     * $natureza_jurica resource
     * @var NaturezaJurica
     */
    protected $natureza_jurica;
 /**
     * Inject dependencies by constructor
     *
     */
    public function __construct(Dispatcher $api, Shield $auth, NaturezaJurica $natureza_jurica)
    {
        parent::__construct($api, $auth);

        $this->natureza_jurica = $natureza_jurica;
    }

    /**
     * Return listing of the resource.
     *
     * @return Response Json
     */
    public function index()
    {
        return $this->natureza_jurica->paginate($this->limit);
    }

}
