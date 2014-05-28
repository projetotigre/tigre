<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use GuzzleHttp\Client as Client;

class SiconvImporter extends Command {

	protected $client;

	protected $base_url = 'http://api.convenios.gov.br';

	protected $resources = array(
		'proponentes' => '/siconv/v1/consulta/proponentes.json',
		'areas_atuacao_proponente' => '/siconv/v1/consulta/areas_atuacao_proponente.json',
        'municipios' => '/siconv/v1/consulta/municipios.json',
		'empenhos' => '/siconv/v1/consulta/empenhos.json',
		'convenios' => '/siconv/v1/consulta/convenios.json',
	);

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
	protected $description = 'Faz a importa&ccedil&atildeo dos dados, apartir da API do Siconv.';

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
		$this->client = new GuzzleHttp\Client(array(
			'base_url' => $this->base_url
		));

		$resource_key = $this->option('resource');

		if(!in_array($resource_key, array_keys($this->resources)))
		{
			return $this->error('Recurso invÃ¡lido, favor checar a documentaÃ§Ã£o.');
		}

		$this->info('Iniciando a importaÃ§Ã£o do recurso '. ucfirst($resource_key) .'.');

		$this->paginate($resource_key);
	}

	/**
	 * Pagina os dados da API de ConvÃªnios
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

            case 'convenios':
            	$this->importConvenios($data);
            break;

			case 'all':
				$this->importProponentes($data);
                $this->importAreasAtuacaoProponente($data);
                $this->importMunicipios($data);
                $this->importEmpenhos($data);
                $this->importConvenios($data);
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

			Proponente::create(array(
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
			));
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
			$this->comment('Importando Area de AtuaÃ§Ã£o:'. $item['id']. '.');

			AreaAtuacaoProponente::create(array(
				'id_siconv' => $item['id'],
				'descricao' => ucfirst_words($item['descricao'])
			));
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

			Municipio::create(array(
				'nome' => $item['nome'],
				'municipio_id' => $item['id'],
				'regiao_nome' => $item['uf']['regiao']['nome'],
				'regiao_sigla' => $item['uf']['regiao']['sigla'],
				'uf_nome' => $item['uf']['nome'],
				'uf_sigla' => $item['uf']['sigla'],
			));
		}
	}

    /**
     * Importa os dados de Empenhos
     * @param  array $data retornado da api do siconv
     */
    public function importEmpenhos($data)
    {
        foreach ($data['empenhos'] as $item)
        {
            $this->comment('Importando Empenho:'. $item['id']. '.');

            Empenho::create(array(
                'empenho_id' => $item['id'],
                'numero' => $item['numero'],
                'especie_id' => $item['especie']['EspecieEmpenho']['id'],
                'convenio_id' => $item['convenio']['Convenio']['id'],
                'cod_unidade_gestora_emitente' => $item['cod_unidade_gestora_emitente'],
                'cod_unidade_gestora_referencia' => $item['cod_unidade_gestora_referencia'],
                'cod_unidade_gestora_responsavel' => $item['cod_unidade_gestora_responsavel'],
                'cod_gestao_emitente' => $item['cod_gestao_emitente'],
                'cod_gestao_referencia' => $item['cod_gestao_referencia'],
                'cod_fonte_recurso' => $item['cod_fonte_recurso'],
                'numero_plano_trabalho_resumido' => $item['numero_plano_trabalho_resumido'],
                'numero_plano_interno' => $item['numero_plano_interno'],
                'esfera_orcamentaria' => $item['esfera_orcamentaria'],
                'data_emissao' => $item['data_emissao'],
                'numero_interno_concedente' => $item['numero_interno_concedente'],
                'numero_interno_concedente_referencia' => $item['numero_interno_concedente_referencia'],
                'observacao' => $item['observacao'],
                'situacao' => $item['situacao'],
                'numero_lista' => $item['numero_lista'],
                'cod_unidade_orcamentaria' => $item['cod_unidade_orcamentaria'],
                'subitem_natureza_despesa_descricao' => $item['natureza_despesa_subitem']['descricao'],
                'subitem_natureza_despesa_numero' => $item['natureza_despesa_subitem']['numero'],
                'valor' => $item['valor'],
                'numero_empenho_referencia' => $item['numero_empenho_referencia'],
            ));
        }
    }

    /**
     * Importa os dados de Convenios
     * @param  array $data retornado da api do siconv
     * @author Rafael Lima
     * @since 2014-05-25
     */
    public function importConvenios($data)
    {
    	foreach ($data['convenios'] as $item)
    	{
    		$this->comment('Importando Convenio:'. $item['id']. '.');

    		Convenio::create(array(
    			'contrato_id'            => $item['id'],
    			'modalidade'             => $item['modalidade'],
    			'id_orgao'               => $item['orgao_concedente']['Orgao']['id'],
    			'justificativa_resumida' => $item['justificativa_resumida'],
    			'objeto_resumido'        => $item['objeto_resumido'],
    			'data_inicio_vigencia'   => $item['data_inicio_vigencia'],
    			'data_fim_vigencia'      => $item['data_fim_vigencia'],
    			'valor_global'           => $item['valor_global'],
    			'valor_repasse_uniao'    => $item['valor_repasse'],
    			'valor_contrapartida'    => $item['valor_contra_partida'],
    			'data_assinatura'        => $item['data_assinatura'],
    			'data_publicacao'        => $item['data_publicacao'],
    			'id_situacao_convenio'   => $item['situacao']['SituacaoConvenio']['id'],
    			'proponente_id'          => $item['proponente']['Proponente']['id'],
    		));
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
