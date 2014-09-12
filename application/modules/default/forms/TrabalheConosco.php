<?php

class Default_Form_TrabalheConosco extends Zend_Form 
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
		
		$this->setAttrib('class','formdefault trabalheForm');
		$this->setLegend('Trabalhe Conosco');
		
		$this->addElements(array(
			'trabalhe_nome' => array(
				'text',array(
					'label' => 'Nome',
					'class' => 'text left big',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'trabalhe_email' => array(
				'text',array(
					'label' => 'E-mail',
					'class' => 'text clear big',
					'validators' => array(
						'EmailAddress'
					),
					'required' => true
				)
			),
			'trabalhe_telefone' => array(
				'text',array(
					'label' => 'Telefone',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'trabalhe_celular' => array(
				'text',array(
					'label' => 'Celular',
					'class' => 'text right',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'trabalhe_cidade' => array(
				'text',array(
					'label' => 'Cidade',
					'class' => 'text left clear',
					'validators' => array(
						'NotEmpty'
					),
					'required' => true
				)
			),
			'trabalhe_estado' => array(
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
			'trabalhe_curriculo' => array(
				'file',array(
					'label' => 'Currículo (pdf, doc, docx)',
					'class' => 'left clear big',
					'validators' => array(
						array('Extension',false,'pdf,doc,docx')
					),
					'decorators' => array(
						'File',
						'Description',
						'Label',
						'Errors',
						array(array('tipo' => 'HtmlTag'), array('tag' => 'div'))
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