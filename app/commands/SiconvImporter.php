<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use GuzzleHttp\Client as Client;

class SiconvImporter extends Command {

	protected $client;

	protected $base_url = 'http://api.convenios.gov.br';

	protected $resources = [
		'proponentes' => '/siconv/v1/consulta/proponentes.json',
		'areas_atuacao_proponente' => '/siconv/v1/consulta/areas_atuacao_proponente.json',
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
		$this->client = new GuzzleHttp\Client([			
			'base_url' => $this->base_url
		]);


		$resource_key = $this->option('resource');

		if(!in_array($resource_key, array_keys($this->resources)))
		{
			return $this->error('Recurso inválido, favor checar a documentação.');
		}

		$this->info('Iniciando a importação do recurso '. ucfirst($resource_key) .'.');		

		$this->paginate($resource_key);		
	}

	/**
	 * Pagina os dados da API de Convênios
	 * @param  array $data array retornado da api do siconv
	 * @return [type] [description]
	 */
	public function paginate($resource_key)
	{
		// Value where to begin the search
		$offset_value = 0;

		do
		{	
			// Send a request to http://api.convenios.gov.br
			$response = $this->client->get($this->resources[$resource_key] . "?offset=$offset_value");

			//convert to json
			$data = $response->json();					
			$offset_value = $offset_value + 500;

			$this->import($resource_key, $data);

		}while( $offset_value < $data['metadados']['total_registros']);
	}

	/**
	 * Pagina os dados da API de Convênios
	 * @param  array $data array retornado da api do siconv
	 * @return [type] [description]
	 */
	public function import($resource_key, $data)
	{
		switch ($resource_key) {
			case 'proponentes':				
				$this->importProponentes($data);
			break;

			case 'areas_atuacao_proponente':				
				$this->importAreasAtuacaoProponente($data);
			break;
						
			default:
				# code...
			break;
		}
	}

	/**
	 * Importa os dados de Proponentes
	 * @param  array $data retornado da api do siconv
	 * @return [type]      	[description]
	 */
	public function importProponentes($data)
	{				
		foreach ($data['proponentes'] as $item)
		{
			$this->comment('Importando proponente CNPJ:'.$item['cnpj'].'.');

			Proponente::create([
				'cnpj' => $item['cnpj'],
				'nome' => $item['nome'],
				'esfera_administrativa_id' => $item['esfera_administrativa']['EsferaAdministrativa']['id'],
				'municipio_id' => $item['municipio']['Municipio']['id'],
				'endereco' => $item['endereco'],
				'cep' => $item['cep'],
				'PessoaResponsavel' => $item['id'],
				'cpf_responsavel' => $item['cpf_responsavel'],
				'nome_responsavel' => $item['nome_responsavel'],
				'telefone' => $item['telefone'],
				'fax' => $item['fax'],
				'natureza_juridica_id' => $item['natureza_juridica']['NaturezaJuridica']['id'],
				'inscricao_estadual' => $item['inscricao_estadual'],
				'inscricao_municipal' => $item['inscricao_municipal']
			]);
		}
	}


	/**
	 * Importa os dados de Areas Atuacao de Proponentes
	 * @param  array $data retornado da api do siconv
	 * @return [type]      	[description]
	 */
	public function importAreasAtuacaoProponente($data)
	{				
		foreach ($data['areas_atuacao_proponente'] as $item)
		{
			$this->comment('Importando Area de Atuação:'. $item['id']. '.');

			AreaAtuacaoProponente::create([
				'id_siconv' => $item['id'],
				'descricao' => ucfirst(mb_strtolower($item['descricao'],'UTF-8'))
			]);
		}
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
