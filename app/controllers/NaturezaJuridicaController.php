<?php

class NaturezaJuricaController extends \BaseController
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
    public function __construct(NaturezaJurica $natureza_jurica)
    {
        $this->natureza_jurica = $natureza_jurica;
    }

    /**
     * Return listing of the resource.
     *
     * @return Response Json
     */
    public function index()
    {
        return $this->natureza_jurica->getAll();
    }

}
