<?php

class Lepard_Sigep_Tracking {
	
	private $numero;
	private $data = Array (
							'tipo' => '',
							'status' => '',
							'data' => '',
							'hora' => '',
							'descricao' => '',
							'recebedor' => array(), 
							'documento' => array(),
							'comentario' => Array(),
							'local' => '',
							'codigo' => '',
							'cidade' => '',
							'uf' => '',
							'sto' => '',
							'destino' => array('local' => '','codigo' => '', 'cidade' => '', 'bairro' => '', 'uf' => '')
					); 
	
	
	
	
	/**
	 * 
	 * @param string $track
	 * @return Lepard_Sigep_Tracking
	 */
	function __construct($track='') {
	
		if ($track != '') $this->get($track);
		
		return $this;
	}
	
	
	/**
	 * 
	 * @param string $track
	 */
	function get($track) {
		
		$data = $this->getTrackingData($track);
		
		$this->bind($data);
		
		return;
	}
	
	/**
	 * 
	 * @param array $data
	 */
	private function bind($data) {
		
		if (is_array($data)) {
			
			
			if (isset($data['evento'][0])) $this->data = array_merge($this->data,$data['evento'][0]);
			else $this->data = array_merge($this->data,$data['evento']);			
			
			$this->numero = $data['numero'];
		}
		
	}
	
	/**
	 * Retorna o número de rastreio
	 * @return string
	 */
	function getNumero() {
		return $this->numero;
	}
	

	/**
	 * Busca um registro pelo código de rastreio
	 * @param string $track
	 * @return Lepard_Sigep_Tracking
	 */
	static function findOne($track) {
	
		$trackClass = new Lepard_Sigep_Tracking();
		$trackClass->get($track);
	
		return $trackClass;
	
	}
	
	static function findAllEventsByTrack($track) {
	
		$data = self::getTrackingData($track,'T');

		/*if (!isset($data['evento'][0])) {
			$eve = $data['evento'];
			unset($data['evento']);
			$data['evento'][0] = $eve;
		}*/

		return $data;
	
	}
	
	/**
	 * Consulta vários registros e retorna um array de objetos 
	 * @param string or array $tracks
	 * @return multitype:Lepard_Sigep_Tracking
	 */
	static function findAll($tracks) {
		
		if (is_array($tracks)) $tracks = implode('',$tracks);
		$data = self::getTrackingData($tracks);
		
		$return = array();
		

		if (isset($data[0])) {
			
			foreach ($data as $d) {
				$trackClass = new Lepard_Sigep_Tracking();
	
				$trackClass->bind($d);
				
				$return[] = $trackClass;
			}
			
		} elseif (isset($data['numero'])) {

			$trackClass = new Lepard_Sigep_Tracking();
	
			$trackClass->bind($data);
			
			$return[] = $trackClass;
			
		}
		
		return $return;
	}


	/**
	 *
	 * XML return's structure:
	 * 	- versao
	 *  - qtd
	 *  - TipoPesquisa
	 *  - TipoResultado
	 *  - objeto (list)
	 *  	- evento (list)
	 *  		- tipo
	 *  		- status
	 *  		- data
	 *  		- hora
	 *  		- descricao
	 *  		- local
	 *  		- codigo
	 *  		- cidade
	 *  		- uf
	 *  		- sto
	 *  		- destino
	 *  			- local
	 *  			- codigo
	 *  			- cidade
	 *  			- bairro
	 *  			- uf
	 *
	 * @param string $codes
	 * @param string $events
	 * @return array
	 */
	private function getTrackingData($codes,$events='U') {
		
		// new HTTP request to some HTTP address
		$client = new Zend_Http_Client('http://200.252.60.71/sro_bin/sroii_xml.eventos');
		// set some parameters
		$client->setParameterPost('Usuario', 'EDSONLUNEN');
		 //$client->setParameterPost('Usuario', 'ECT');
		$client->setParameterPost('Senha', '3LIN9C0E>7');
		// $client->setParameterPost('Senha', 'SRO');
		$client->setParameterPost('Tipo', 'L');
		$client->setParameterPost('Resultado', $events);
		$client->setParameterPost('Objetos', $codes);
	
		try {
			
		$xmlString = $client->request(Zend_Http_Client::POST);
		$xmlString = $xmlString->getBody();
		$TrackingData = json_decode(json_encode((array) simplexml_load_string($xmlString)),1);	
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
		
		
		return isset($TrackingData['objeto']) ? $TrackingData['objeto'] : null;
	}
	
	/**
	 * função para chamar os 'getters' e 'setters' dinamicamente
	 *
	 * @return string
	 */
	public function __call($metodo,$argumentos) {
        if (preg_match('/^get(\w+?)?$/', $metodo, $matches)) {
			$funcao = Zend_Filter::filterStatic($matches[1], 'Word_CamelCaseToUnderscore');
			$funcao = Zend_Filter::filterStatic($funcao, 'StringToLower');
			
			if (isset($this->data[$funcao]) || $this->data[$funcao] === null) {
				return $this->data[$funcao];
			} else {
				throw new Zend_Exception('Campo não encontrado ' . $funcao . ' (' . $matches[1] . ')');
			}
        } elseif (preg_match('/^set(\w+?)?$/', $metodo, $matches)) {
			$funcao = Zend_Filter::filterStatic($matches[1], 'Word_CamelCaseToUnderscore');
			$funcao = Zend_Filter::filterStatic($funcao, 'StringToLower');
			
			if (isset($this->data[$funcao])) {
				$this->data[$funcao] = $argumentos[0];
				return true;
			} else {
				throw new Zend_Exception('Campo não encontrado ' . $funcao . ' (' . $matches[1] . ')');
			}
        }
        
        throw new Zend_Exception('Função não encontrada');
	}
	
}

?>