<?php

class Default_Form_ContatoConsumidor extends Zend_Form 
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
		
		$this->setAttrib('class','formdefault consumidorForm');
		$this->setLegend('Consumidor');
		
		$this->addElements(array(
			'consumidor' => array(
				'hidden',array(
					'decorators' => array('ViewHelper'),
					'value' => '1'
				)
			),
			'consumidor_nome' => array(
				'text',array(
					'label' => 'Nome Completo',
					'class' => 'text left big',
					'maxlength' => '50',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_email' => array(
				'text',array(
					'label' => 'E-mail',
					'class' => 'text left big clear',
					'validators' => array(
						'EmailAddress'
					),
					'required' => true
				)
			),
			'consumidor_nascimento' => array(
				'text',array(
					'label' => 'Data de Nascimento',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_profissao' => array(
				'text',array(
					'label' => 'Profissão',
					'class' => 'text right',
					'style' => '',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_telefone' => array(
				'text',array(
					'label' => 'Telefone',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_celular' => array(
				'text',array(
					'label' => 'Celular',
					'class' => 'text right',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_endereco' => array(
				'text',array(
					'label' => 'Endereço',
					'class' => 'text left big clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_cidade' => array(
				'text',array(
					'label' => 'Cidade',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'consumidor_estado' => array(
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
			'consumidor_mensagem' => array(
				'textarea',array(
					'label' => 'Mensagem',
					'class' => 'left clear',
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