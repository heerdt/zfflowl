<?php

class Default_Form_OndeComprar extends Zend_Form 
{
	
	public function init()
	{
		$this->setDecorators(array(
			'formElements',
			array('HtmlTag', array('tag' => 'dl')),
			array('Description', array('tag' => 'p', 'placement' => 'prepend', 'class' => 'description','escape' => false)),
			'fieldset',
			array('form',array('class' => 'formdefault'))
		));
		$this->setAttrib('id','comprarForm');
		$this->setLegend('Onde Comprar');
		$this->setDescription('A Lez a Lez está presente em mais de 2 mil lojas em todo o Brasil. Preencha o formulário e saiba onde encontrar uma loja perto de você!');
		
		$this->addElements(array(
			'var_nome' => array(
				'text',array(
					'label' => 'Nome:',
					'class' => 'text',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'var_email' => array(
				'text',array(
					'label' => 'E-mail:',
					'class' => 'text',
					'validators' => array(
						'EmailAddress'
					),
					'required' => true
				)
			),
			'estado' => array(
				'select',array(
					'label' => 'Estado:',
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
			'cidade' => array(
				'select',array(
					'label' => 'Cidade:',
					'multiOptions' => array(
					),
					'registerInArrayValidator' => false
				)
			),
			'btn_enviar' => array(
				'image',array(
					'value' => 'Enviar',
					'src' => $this->getView()->url(array(),'media-index') . 'styles/default/images/botao-enviar.jpg',
					'class' => 'btn-enviar'
				)
			)
		));
	}
	
}