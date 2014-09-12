<?php



define('VERSAO', "1.1.0");

define("ENDERECO_BASE", "https://ecommerce.cielo.com.br");
define("ENDERECO", ENDERECO_BASE."/servicos/ecommwsec.do");

/*
// CONSTANTES

define("LOJA", "1006993069");
define("LOJA_CHAVE", "25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3");
define("CIELO", "1001734898");
define("CIELO_CHAVE", "e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832");
*/




// Verifica em Resposta XML a ocorr�ncia de erros
// Par�metros: XML de envio, XML de Resposta
function VerificaErro($vmPost, $vmResposta)
{
	$error_msg = null;

	try
	{
		if(stripos($vmResposta, "SSL certificate problem") !== false)
		{
			throw new Exception("CERTIFICADO INV�LIDO - O certificado da transa��o n�o foi aprovado", "099");
		}
			
		$objResposta = simplexml_load_string($vmResposta, null, LIBXML_NOERROR);
		if($objResposta == null)
		{
			throw new Exception("HTTP READ TIMEOUT - o Limite de Tempo da transa��o foi estourado", "099");
		}
	}
	catch (Exception $ex)
	{
		$error_msg = "     C�digo do erro: " . $ex->getCode() . "\n";
		$error_msg .= "     Mensagem: " . $ex->getMessage() . "\n";
			
		// Gera p�gina HTML
		echo '<html><head><title>Erro na transa��o</title></head><body>';
		echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transa��o!</span>' . '<br />';
		echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
		echo '<pre>' . $error_msg . '<br /><br />';
		//echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
		echo '</pre><p><center>';
		echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' .
				'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
		echo '</center></p></body></html>';
		$error_msg .= "     XML de envio: " . "\n" . $vmPost;

		// Dispara o erro
		trigger_error($error_msg, E_USER_ERROR);
			
		return true;
	}

	if($objResposta->getName() == "erro")
	{
		$error_msg = "     C�digo do erro: " . $objResposta->codigo . "\n";
		$error_msg .= "     Mensagem: " . utf8_decode($objResposta->mensagem) . "\n";
		// Gera p�gina HTML
		echo '<html><head><title>Erro na transa��o</title></head><body>';
		echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transa��o!</span>' . '<br />';
		echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
		echo '<pre>' . $error_msg . '<br /><br />';
		//echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
		echo '</pre><p><center>';
		echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' .
				'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
		echo '</center></p></body></html>';
		$error_msg .= "     XML de envio: " . "\n" . $vmPost;

		// Dispara o erro
		trigger_error($error_msg, E_USER_ERROR);
	}
}



// Envia requisição
function httprequest($paEndereco, $paPost){

	$sessao_curl = curl_init();
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);

	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

	//  CURLOPT_SSL_VERIFYPEER
	//  verifica a validade do certificado
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
	//  CURLOPPT_SSL_VERIFYHOST
	//  verifica se a identidade do servidor bate com aquela informada no certificado
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

	//  CURLOPT_SSL_CAINFO
	//  informa a localização do certificado para verificação com o peer
	curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() .
			"/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
	curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);

	//  CURLOPT_CONNECTTIMEOUT
	//  o tempo em segundos de espera para obter uma conexão
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

	//  CURLOPT_TIMEOUT
	//  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

	//  CURLOPT_RETURNTRANSFER
	//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
	//  invés de imprimir o resultado na tela. Retorna FALSE se há problemas na requisição
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($sessao_curl, CURLOPT_POST, true);
	curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );

	$resultado = curl_exec($sessao_curl);

	curl_close($sessao_curl);

	if ($resultado)
	{
		return $resultado;
	}
	else
	{
		return curl_error($sessao_curl);
	}
}




// Monta URL de retorno
function ReturnURL()
{
	$pageURL = 'http';

	if ($_SERVER["SERVER_PORT"] == 443) // protocolo https
	{
		$pageURL .= 's';
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"]. substr($_SERVER["REQUEST_URI"], 0);
	}
	// ALTERNATIVA PARA SERVER_NAME -> HOST_HTTP

	$file = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

	$ReturnURL = str_replace($file, "retorno.php", $pageURL);

	return $ReturnURL;
}





class Lepard_Cielo
{
	private $logger;

	public $dadosEcNumero;
	public $dadosEcChave;

	public $dadosPortadorNumero;
	public $dadosPortadorVal;
	public $dadosPortadorInd;
	public $dadosPortadorCodSeg;
	public $dadosPortadorNome;

	public $dadosPedidoNumero;
	public $dadosPedidoValor;
	public $dadosPedidoMoeda = "986";
	public $dadosPedidoData;
	public $dadosPedidoDescricao;
	public $dadosPedidoIdioma = "PT";

	public $formaPagamentoBandeira;
	public $formaPagamentoProduto;
	public $formaPagamentoParcelas;

	public $urlRetorno;
	public $autorizar;
	public $capturar;

	public $tid;
	public $status;
	public $urlAutenticacao;

	const ENCODING = "ISO-8859-1";

	function __construct()
	{
		// cria um logger
		//$this->logger = new Logger();
	}

	// Geradores de XML
	private function XMLHeader()
	{
		return '<?xml version="1.0" encoding="' . self::ENCODING . '" ?>';
	}

	private function XMLDadosEc()
	{
		$msg = '<dados-ec>' . "\n      " .
				'<numero>'
				. $this->dadosEcNumero .
				'</numero>' . "\n      " .
				'<chave>'
				. $this->dadosEcChave .
				'</chave>' . "\n   " .
				'</dados-ec>';
			
		return $msg;
	}

	private function XMLDadosPortador()
	{
		$msg = '<dados-portador>' . "\n      " .
				'<numero>'
				. $this->dadosPortadorNumero .
				'</numero>' . "\n      " .
				'<validade>'
				. $this->dadosPortadorVal .
				'</validade>' . "\n      " .
				'<indicador>'
				. $this->dadosPortadorInd .
				'</indicador>' . "\n      " .
				'<codigo-seguranca>'
				. $this->dadosPortadorCodSeg .
				'</codigo-seguranca>' . "\n   ";
			
		// Verifica se Nome do Portador foi informado
		if($this->dadosPortadorNome != null && $this->dadosPortadorNome != "")
		{
			$msg .= '   <nome-portador>'
			. $this->dadosPortadorNome .
			'</nome-portador>' . "\n   " ;
		}
			
		$msg .= '</dados-portador>';
			
		return $msg;
	}

	private function XMLDadosCartao()
	{
		$msg = '<dados-cartao>' . "\n      " .
				'<numero>'
				. $this->dadosPortadorNumero .
				'</numero>' . "\n      " .
				'<validade>'
				. $this->dadosPortadorVal .
				'</validade>' . "\n      " .
				'<indicador>'
				. $this->dadosPortadorInd .
				'</indicador>' . "\n      " .
				'<codigo-seguranca>'
				. $this->dadosPortadorCodSeg .
				'</codigo-seguranca>' . "\n   ";

		// Verifica se Nome do Portador foi informado
		if($this->dadosPortadorNome != null && $this->dadosPortadorNome != "")
		{
			$msg .= '   <nome-portador>'
			. $this->dadosPortadorNome .
			'</nome-portador>' . "\n   " ;
		}
			
		$msg .= '</dados-cartao>';
			
		return $msg;
	}

	private function XMLDadosPedido()
	{
		$this->dadosPedidoData = date("Y-m-d") . "T" . date("H:i:s");
		$msg = '<dados-pedido>' . "\n      " .
				'<numero>'
				. $this->dadosPedidoNumero .
				'</numero>' . "\n      " .
				'<valor>'
				. $this->dadosPedidoValor .
				'</valor>' . "\n      " .
				'<moeda>'
				. $this->dadosPedidoMoeda .
				'</moeda>' . "\n      " .
				'<data-hora>'
				. $this->dadosPedidoData .
				'</data-hora>' . "\n      ";
		if($this->dadosPedidoDescricao != null && $this->dadosPedidoDescricao != "")
		{
			$msg .= '<descricao>'
			. $this->dadosPedidoDescricao .
			'</descricao>' . "\n      ";
		}
		$msg .= '<idioma>'
		. $this->dadosPedidoIdioma .
		'</idioma>' . "\n   " .
		'</dados-pedido>';
			
		return $msg;
	}

	private function XMLFormaPagamento()
	{
		$msg = '<forma-pagamento>' . "\n      " .
				'<bandeira>'
				. $this->formaPagamentoBandeira .
				'</bandeira>' . "\n      " .
				'<produto>'
				. $this->formaPagamentoProduto .
				'</produto>' . "\n      " .
				'<parcelas>'
				. $this->formaPagamentoParcelas .
				'</parcelas>' . "\n   " .
				'</forma-pagamento>';
			
		return $msg;
	}
		
	private function XMLUrlRetorno()
	{
		$msg = '<url-retorno>' . $this->urlRetorno . '</url-retorno>';
			
		return $msg;
	}

	private function XMLAutorizar()
	{
		$msg = '<autorizar>' . $this->autorizar . '</autorizar>';
			
		return $msg;
	}

	private function XMLCapturar()
	{
		$msg = '<capturar>' . $this->capturar . '</capturar>';
			
		return $msg;
	}

	// Envia Requisição

	// Envia Requisi��o
	public function Enviar($vmPost, $transacao)
	{
		//$this->logger->logWrite("ENVIO: " . $vmPost, $transacao);
		//Service_Model_Log::write('cielo_cc', $tipo, $loja, $id, $data)
		// ENVIA REQUISI��O SITE CIELO
		
		//$this->logger->logWrite("RESPOSTA: " . $vmResposta, $transacao);
		
		
		
		$vmResposta = httprequest(ENDERECO, "mensagem=" . $vmPost);
		
		
		Service_Model_Log::write('cielo_cc', 'transacao', $this->lojaId, $this->parentId,array(
			'transacao' => $transacao,
			'post' => $vmPost,
			'resposta' => $vmResposta
		));
		
		
		// trata erro de conexão
		try {
			if(stripos($vmResposta, "SSL certificate problem") !== false)
			{
				throw new Exception("CERTIFICADO INVÁLIDO - O certificado da transação não foi aprovado", "099");
			}
				
			$objResposta = simplexml_load_string($vmResposta, null, LIBXML_NOERROR);
			if($objResposta == null)
			{
				throw new Exception("HTTP READ TIMEOUT - o Limite de Tempo da transação foi estourado", "099");
			}
		} catch (Exception $ex) {
			$data = array(
				'codigo' => $ex->getCode(),
				'mensagem' => $ex->getMessage(),
				'xml_envio' => $vmPost,
				'exception' => $ex
			);
			Service_Model_Log::write('cielo_cc', 'erro', $this->lojaId, $this->parentId,$data);
		}
		
		// trata erro no xml da resposta
		if($objResposta->getName() == "erro") {
			
			$data = array(
					'codigo' => (string) $objResposta->codigo,
					'mensagem' => (string) $objResposta->mensagem,
					'xml_envio' => $vmPost
			);
			Service_Model_Log::write('cielo_cc', 'erro', $this->lojaId, $this->parentId,$data);
		}
		
		return simplexml_load_string($vmResposta);
	}

	// Requisições
	public function RequisicaoTransacao($incluirPortador)
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-transacao id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				. $this->XMLDadosEc() . "\n   ";
		if($incluirPortador == true)
		{
			$msg .=	$this->XMLDadosPortador() . "\n   ";
		}
		$msg .=		  $this->XMLDadosPedido() . "\n   "
		. $this->XMLFormaPagamento() . "\n   "
		. $this->XMLUrlRetorno() . "\n   "
		. $this->XMLAutorizar() . "\n   "
		. $this->XMLCapturar() . "\n" ;
			
		$msg .= '</requisicao-transacao>';
		$objResposta = $this->Enviar($msg, "Transacao");
		return $objResposta;
	}

	public function RequisicaoTid()
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-tid id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n   "
				. $this->XMLDadosEc() . "\n   "
				. $this->XMLFormaPagamento() . "\n" .
				'</requisicao-tid>';

		$objResposta = $this->Enviar($msg, "Requisicao Tid");
		return $objResposta;
	}

	public function RequisicaoAutorizacaoPortador()
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-autorizacao-portador id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n"
				. '<tid>' . $this->tid . '</tid>' . "\n   "
				. $this->XMLDadosEc() . "\n   "
				. $this->XMLDadosCartao() . "\n   "
				. $this->XMLDadosPedido() . "\n   "
				. $this->XMLFormaPagamento() . "\n   "
				. '<capturar-automaticamente>' . $this->capturar . '</capturar-automaticamente>' . "\n" .
				'</requisicao-autorizacao-portador>';
			
		$objResposta = $this->Enviar($msg, "Autorizacao Portador");
		return $objResposta;
	}

	public function RequisicaoAutorizacaoTid()
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-autorizacao-tid id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n  "
				. '<tid>' . $this->tid . '</tid>' . "\n  "
				. $this->XMLDadosEc() . "\n" .
				'</requisicao-autorizacao-tid>';

		$objResposta = $this->Enviar($msg, "Autorizacao Tid");
		return $objResposta;
	}

	public function RequisicaoCaptura($PercentualCaptura, $anexo)
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-captura id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				. '<tid>' . $this->tid . '</tid>' . "\n   "
				. $this->XMLDadosEc() . "\n   "
				. '<valor>' . $PercentualCaptura . '</valor>' . "\n";
		if($anexo != null && $anexo != "")
		{
			$msg .=	'   <anexo>' . $anexo . '</anexo>' . "\n";
		}
		$msg .= '</requisicao-captura>';
			
		$objResposta = $this->Enviar($msg, "Captura");
		return $objResposta;
	}

	public function RequisicaoCancelamento()
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-cancelamento id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				. '<tid>' . $this->tid . '</tid>' . "\n   "
				. $this->XMLDadosEc() . "\n" .
				'</requisicao-cancelamento>';
			
		$objResposta = $this->Enviar($msg, "Cancelamento");
		return $objResposta;
	}

	public function RequisicaoConsulta()
	{
		$msg = $this->XMLHeader() . "\n" .
				'<requisicao-consulta id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				. '<tid>' . $this->tid . '</tid>' . "\n   "
				. $this->XMLDadosEc() . "\n" .
				'</requisicao-consulta>';
			
		$objResposta = $this->Enviar($msg, "Consulta");
		return $objResposta;
	}


	// Transforma em/lê string
	public function ToString()
	{
		$msg = $this->XMLHeader() .
		'<objeto-pedido>'
		. '<tid>' . $this->tid . '</tid>'
		. '<status>' . $this->status . '</status>'
		. $this->XMLDadosEc()
		. $this->XMLDadosPedido()
		. $this->XMLFormaPagamento() .
		'</objeto-pedido>';

		return $msg;
	}

	public function FromString($Str)
	{
		$DadosEc = "dados-ec";
		$DadosPedido = "dados-pedido";
		$DataHora = "data-hora";
		$FormaPagamento = "forma-pagamento";
			
		$XML = simplexml_load_string($Str);
			
		$this->tid = $XML->tid;
		$this->status = $XML->status;
		$this->dadosEcChave = $XML->$DadosEc->chave;
		$this->dadosEcNumero = $XML->$DadosEc->numero;
		$this->dadosPedidoNumero = $XML->$DadosPedido->numero;
		$this->dadosPedidoData = $XML->$DadosPedido->$DataHora;
		$this->dadosPedidoValor = $XML->$DadosPedido->valor;
		$this->formaPagamentoProduto = $XML->$FormaPagamento->produto;
		$this->formaPagamentoParcelas = $XML->$FormaPagamento->parcelas;
	}

	// Traduz cógigo do Status
	public function getStatus()
	{
		switch($this->status)
		{
			case "0": $status = "criada";
			break;
			case "1": $status = "em-andamento";
			break;
			case "2": $status = "autenticada";
			break;
			case "3": $status = "nao-autenticada";
			break;
			case "4": $status = "autorizada";
			break;
			case "5": $status = "nao-autorizada";
			break;
			case "6": $status = "capturada";
			break;
			case "8": $status = "nao-capturada";
			break;
			case "9": $status = "cancelada";
			break;
			case "10": $status = "em-autenticacao";
			break;
			default: $status = "n/a";
			break;
		}
			
		return $status;
	}
	
	
	static function ccType($ccNum) {
		/*
		 * mastercard: Must have a prefix of 51 to 55, and must be 16 digits in length.
		* Visa: Must have a prefix of 4, and must be either 13 or 16 digits in length.
		* American Express: Must have a prefix of 34 or 37, and must be 15 digits in length.
		* Diners Club: Must have a prefix of 300 to 305, 36, or 38, and must be 14 digits in length.
		* Discover: Must have a prefix of 6011, and must be 16 digits in length.
		* JCB: Must have a prefix of 3, 1800, or 2131, and must be either 15 or 16 digits in length.
		*/
	
		/* nomes para cielo
		 * “visa” “mastercard” “diners” “discover” “elo” “amex” “jcb” “aura”
		*/
	
		if (ereg("^5[1-5][0-9]{14}$", $ccNum))
			return "mastercard";
	
		if (ereg("^4[0-9]{12}([0-9]{3})?$", $ccNum))
			return "visa";
	
		if (ereg("^3[47][0-9]{13}$", $ccNum))
			return "amex";
	
		if (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $ccNum))
			return "diners";
	
		if (ereg("^6011[0-9]{12}$", $ccNum))
			return "discover";
	
		if (ereg("^(3[0-9]{4}|2131|1800)[0-9]{11}$", $ccNum))
			return "jcb";
	
		if (ereg("^5067[0-9]{12}$", $ccNum) ||  
			ereg("^6277[0-9]{12}$", $ccNum) || 
			ereg("^6031[0-9]{12}$", $ccNum) || 
			ereg("^6363[0-9]{12}$", $ccNum) || 
			ereg("^6063[0-9]{12}$", $ccNum) ||
			ereg("^6042[0-9]{12}$", $ccNum) ||
			1
			)
			return "elo";
	}
	
	
	static function ccTypeClearsale($ccNum) {
		/*
		 * mastercard: Must have a prefix of 51 to 55, and must be 16 digits in length.
		* Visa: Must have a prefix of 4, and must be either 13 or 16 digits in length.
		* American Express: Must have a prefix of 34 or 37, and must be 15 digits in length.
		* Diners Club: Must have a prefix of 300 to 305, 36, or 38, and must be 14 digits in length.
		* Discover: Must have a prefix of 6011, and must be 16 digits in length.
		* JCB: Must have a prefix of 3, 1800, or 2131, and must be either 15 or 16 digits in length.
		*/
	
		/* nomes para cielo
		 * “visa” “mastercard” “diners” “discover” “elo” “amex” “jcb” “aura”
		*/
	
		if (ereg("^5[1-5][0-9]{14}$", $ccNum))
			return 2;
	
		if (ereg("^4[0-9]{12}([0-9]{3})?$", $ccNum))
			return 3;
	
		if (ereg("^3[47][0-9]{13}$", $ccNum))
			return 5;
	
		if (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $ccNum))
			return 1;
	
		if (ereg("^6011[0-9]{12}$", $ccNum))
			return 4;
	
		if (ereg("^(3[0-9]{4}|2131|1800)[0-9]{11}$", $ccNum))
			return 4;
	}

}
