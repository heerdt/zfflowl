<?php

class Default_Form_ContatoLojista extends Zend_Form 
{
	
	public function init()
	{
		$this->setDecorators(array(
			array('Description', array('tag' => 'p', 'class' => 'description','escape' => false)),
			'formElements',
			'fieldset',
			array('form',array('class' => 'formdefault'))
		));
		$this->setElementDecorators(array(
			'ViewHelper',
			'Description',
			'Label',
			'Errors',
			array(array('tipo' => 'HtmlTag'), array('tag' => 'div'))
		));
		
		$this->setAttrib('class','formdefault lojistaForm');
		$this->setLegend('Lojista');
		
		$this->addElements(array(
			'lojista' => array(
				'hidden',array(
					'decorators' => array('ViewHelper'),
					'value' => '1'
				)
			),
			'lojista_nome' => array(
				'text',array(
					'label' => 'Nome do Contato',
					'class' => 'text left big',
					'maxlength' => '50',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_email' => array(
				'text',array(
					'label' => 'E-mail',
					'class' => 'text left big clear',
					'validators' => array(
						'EmailAddress'
					),
					'required' => true
				)
			),
			'lojista_telefone' => array(
				'text',array(
					'label' => 'Telefone',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_celular' => array(
				'text',array(
					'label' => 'Celular',
					'class' => 'text right',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_razaosocial' => array(
				'text',array(
					'label' => 'Razão Social',
					'class' => 'text left clear',
					'maxlength' => '50',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_cnpj' => array(
				'text',array(
					'label' => 'CNPJ',
					'class' => 'text right',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_endereco' => array(
				'text',array(
					'label' => 'Endereço',
					'class' => 'text left big clear',
					'validators' => array(
						'NotEmpty'
					),
					'maxlength' => '35',
					'required' => true
				)
			),
			'lojista_bairro' => array(
				'text',array(
					'label' => 'Bairro',
					'class' => 'text left clear',
					'maxlength' => '35',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_cep' => array(
				'text',array(
					'label' => 'CEP',
					'class' => 'text right',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_cidade' => array(
				'text',array(
					'label' => 'Cidade',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_estado' => array(
				'select',array(
					'label' => 'Estado',
					'class' => 'right',
					'multiOptions' => array(
						'' => 'Selecione - Estado',
						'AC' => 'Acre',
						'AL' => 'Alagoas',
						'AP' => 'Amapá',
						'AM' => 'Amazonas',
						'BA' => 'Bahia',
						'CE' => 'Ceará',
						'DF' => 'Distrito Federal',
						'ES' => 'Espírito Santo',
						'GO' => 'Goiás',
						'MA' => 'Maranhão',
						'MT' => 'Mato Grosso',
						'MS' => 'Mato Grosso do Sul',
						'MG' => 'Minas Gerais',
						'PA' => 'Pará',
						'PB' => 'Paraíba',
						'PR' => 'Paraná',
						'PE' => 'Pernambuco',
						'PI' => 'Piauí',
						'RJ' => 'Rio de Janeiro',
						'RN' => 'Rio Grande do Norte',
						'RS' => 'Rio Grande do Sul',
						'RO' => 'Rondônia',
						'RR' => 'Roraima',
						'SC' => 'Santa Catarina',
						'SP' => 'São Paulo',
						'SE' => 'Sergipe',
						'TO' => 'Tocantins'
					),
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'lojista_mensagem' => array(
				'textarea',array(
					'label' => 'Mensagem',
					'class' => 'textarea clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'btn_enviar' => array(
				'image',array(
					'class' => 'left clear btn-enviar',
					'value' => 'Enviar',
					'src' => $this->getView()->url(array(),'media-index') . 'styles/default/images/btn-enviar.png',
				)
			)
		));
	}
	
}