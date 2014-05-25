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
        'municipios' => '/siconv/v1/consulta/municipios.json',
		'empenhos' => '/siconv/v1/consulta/empenhos.json',
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

			case 'municipios':
                $this->importMunicipios($data);
            break;

            case 'empenhos':
				$this->importEmpenhos($data);
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
				'descricao' => ucfirst_words($item['descricao'])
			]);
		}
	}

	/**
	 * Importa os dados de Areas Atuacao de Proponentes
	 * @param  array $data retornado da api do siconv
	 * @return [type]      	[description]
	 */
	public function importMunicipios($data)
	{
		foreach ($data['municipios'] as $item)
		{
			$this->comment('Importando Municipio:'. $item['id']. '.');

			Municipio::create([
				'nome' => ucfirst_words($item['nome'],'UTF-8'),
				'municipio_id' => $item['id'],
				'regiao_nome' => ucfirst_words($item['uf']['regiao']['nome']),
				'regiao_sigla' => $item['uf']['regiao']['sigla'],
				'uf_nome' => ucfirst_words($item['uf']['nome']),
				'uf_sigla' => $item['uf']['sigla'],
			]);
		}
	}

    /**
     * Importa os dados de Empenhos
     * @param  array $data retornado da api do siconv
     */
    public function importEmpenhos($data)
    {
        foreach ($data['municipios'] as $item)
        {
            $this->comment('Importando Empenho:'. $item['id']. '.');

            Empenho::create([
                'empenho_id',
                'numero',
                'especie_id',
                'convenio_id',
                'cod_unidade_gestora_emitente',
                'cod_unidade_gestora_referencia',
                'cod_unidade_gestora_responsavel',
                'cod_gestao_emitente',
                'cod_gestao_referencia',
                'cod_fonte_recurso',
                'numero_plano_trabalho_resumido',
                'numero_plano_interno',
                'esfera_orcamentaria',
                'data_emissao',
                'numero_interno_concedente',
                'numero_interno_concedente_referencia',
                'observacao',
                'situacao',
                'numero_lista',
                'cod_unidade_orcamentaria',
                'subitem_natureza_despesa_descricao',
                'subitem_natureza_despesa_numero',
                'valor',
                'numero_empenho_referencia',
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
