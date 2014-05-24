<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use GuzzleHttp\Client as Client;

class SiconvImporter extends Command {

	protected $resources = [
		'proponentes' => '/siconv/v1/consulta/proponentes.json',
	];

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'siconv:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Faz a importação dos dados, apartir da API do Siconv.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();		
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$client = new Client();

		// Create a client with a base URL
		$client = new GuzzleHttp\Client([			
			'base_url' => 'http://api.convenios.gov.br'
		]);

		$resource = $this->option('resource');

		if(!in_array($resource, array_keys($this->resources)))
		{
			return $this->error('Recurso inválido, favor checar a documentação.');
		}

		$this->info('Iniciando a importação do recurso '.$resource.'.');

		// Send a request to http://api.convenios.gov.br
		$response = $client->get('/siconv/v1/consulta/proponentes.json');

		//convert to json
		$data = $response->json();		

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('resource', null, InputOption::VALUE_REQUIRED, 'Defina o recurso que deseja importar.', null),
		);
	}

}
