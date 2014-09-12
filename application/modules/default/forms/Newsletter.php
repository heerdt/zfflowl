<?php

class Default_Form_Newsletter extends Zend_Form 
{
	
	public function init()
	{
		$this->setDecorators(array(
			'formElements',
			array('HtmlTag', array('tag' => 'dl')),
			array('Description', array('tag' => 'p', 'placement' => 'prepend', 'class' => 'description','escape' => false)),
			'fieldset',
			array('form',array('class' => ''))
		));
		$this->setAttrib('id','newsletterForm');
		$this->setLegend('Newsletter');
		
		$this->addElements(array(
			'var_emailnewsletter' => array(
				'text',array(
					'label' => 'E-mail',
					'class' => 'text',
					'value' => 'Receba novidades no seu e-mail',
					'validators' => array(
						'EmailAddress'
					),
					'required' => true
				)
			),
			'btn_enviarnewsletter' => array(
				'image',array(
					'value' => 'Enviar',
					'src' => $this->getView()->url(array(),'media-index') . 'styles/default/images/newletter-submit.gif',
					'class' => 'btn-enviar'
				)
			)
		));
	}
	
}